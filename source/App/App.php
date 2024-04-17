<?php

namespace Source\App;

use Source\Core\Controller;
use Source\Core\Session;
use Source\Core\View;
use Source\Models\Auth;
use Source\Models\CafeApp\AppCategory;
use Source\Models\CafeApp\AppCreditCard;
use Source\Models\CafeApp\AppInvoice;
use Source\Models\CafeApp\AppOrder;
use Source\Models\CafeApp\AppPlan;
use Source\Models\CafeApp\AppSubscription;
use Source\Models\CafeApp\AppWallet;
use Source\Models\Post;
use Source\Models\Report\Access;
use Source\Models\Report\Online;
use Source\Models\User;
use Source\Support\Email;
use Source\Support\Message;
use Source\Support\Thumb;
use Source\Support\Upload;

/**
 * Class App
 * @package Source\App
 */
class App extends Controller
{
    /** @var User */
    private $user;

    /**
     * App constructor.
     */
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW_APP . "/");

        if (!$this->user = Auth::user()) {
            $this->message->warning("Efetue login para acessar o APP.")->flash();
            redirect("/entrar");
        }

        (new Access())->report();
        (new Online())->report();

        (new AppWallet())->start($this->user);
        (new AppInvoice())->fixed($this->user, 3);

        // UNCONFIRMED E-MAIL
        if ($this->user->status != "confirmed") {
            $session = new Session();
            if (!$session->has("appconfirmed")) {
                $this->message->info("IMPORTANTE: Acesse seu e-mail para confirmar seu cadastrado e ativar todos os recursos.")->flash();
                $session->set("appconfirmed", true);
                (new Auth())->register($this->user);
            }
        }

        // $card = new AppCreditCard();
        // $card->creditCard(
        //     $this->user,
        //     "5583 6339 1073 3361",
        //     "Leonardo Moreira",
        //     "02/2025",
        //     "811"
        // );
        // $card = (new AppCreditCard())->findById(1);
        // $tr = $card->transaction(5000);

    }

    /**
     * @param array|null $data
     * 
     * @return void
     */
    public function dash(?array $data): void
    {

        if (!empty($data["wallet"])) {
            $session = new Session();

            if ($data["wallet"] == "all") {
                $session->unset("walletfilter");
                echo json_encode(["filter" => true]);
                return;
            }

            $wallet = filter_var($data["wallet"], FILTER_VALIDATE_INT);
            $getWallet = (new AppWallet())->find(
                "user_id = :user AND id = :id",
                "user={$this->user->id}&id={$wallet}"
            )->count();

            if ($getWallet) {
                $session->set("walletfilter", $wallet);
            }
            echo json_encode(["filter" => true]);
            return;
        }
        // $json["data"] = $data;
        // echo json_encode($json);

        // CHART UPDATE
        $chartData = (new AppInvoice())->chartData($this->user);
        $categories = str_replace("''", "", explode(",", $chartData->categories));
        $json["chart"] = [
            "categories" => $categories,
            "income" => array_map("abs", explode(",", $chartData->income)),
            "expense" => array_map("abs", explode(",", $chartData->expense))

        ];

        // WALLET
        $wallet = (new AppInvoice())->balance($this->user);
        $wallet->wallet = str_price($wallet->wallet);
        $wallet->status = ($wallet->balance == "positive" ? "gradient-green" : "gradient-red");
        $wallet->income = str_price($wallet->income);
        $wallet->expense = str_price($wallet->expense);

        $json["wallet"] = $wallet;

        echo json_encode($json);
    }

    /**
     * APP HOME
     */
    public function home()
    {
        $head = $this->seo->render(
            "Olá {$this->user->first_name}. Vamos controlar? - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        // CHART
        $chartData = (new AppInvoice())->chartData($this->user);
        // ENDCHART


        // INCOME && EXPENSE
        $whereWallet = "";
        if ((new Session())->has("walletfilter")) {
            $whereWallet = "AND wallet_id = " . (new Session())->walletfilter;
        }
        $income = (new AppInvoice())
            ->find(
                "user_id = :user AND type = 'income' AND status = 'unpaid' AND date(due_at) <= DATE(now() + INTERVAL 1 MONTH) {$whereWallet}",
                "user={$this->user->id}"
            )
            ->order("due_at")
            ->fetch(true);

        $expense = (new AppInvoice())
            ->find(
                "user_id = :user AND type = 'expense' AND status = 'unpaid' AND due_at <= DATE(now() + INTERVAL 1 MONTH) {$whereWallet}",
                "user={$this->user->id}"
            )
            ->order("due_at")
            ->fetch(true);
        // END INCOME && EXPENSE

        // WALLET
        $wallet = (new AppInvoice())->balance($this->user);
        // END WALLET
        // POSTS
        $posts = (new Post())
            ->findPost()
            ->limit(3)
            ->order("post_at DESC")
            ->fetch(TRUE);
        // END POSTS

        echo $this->view->render("home", [
            "head" => $head,
            "chart" => $chartData,
            "income" => $income,
            "expense" => $expense,
            "wallet" => $wallet,
            "posts" => $posts
        ]);
    }

    /**
     * @param array $data
     * 
     * @return [type]
     */
    public function filter(array $data)
    {
        $status = (!empty($data["status"]) ? $data["status"] : "all");
        $category = (!empty($data["category"]) ? $data["category"] : "all");
        $date = (!empty($data["date"]) ? $data["date"] : date("m/Y"));

        list($m, $y) = explode("/", $date);

        $m = (($m >= 1 && $m <= 12) ? $m : date("m"));

        $y = (($y <= date("Y", strtotime("+10year"))) ? $y : date("Y", strtotime("+10year")));

        $start = new \DateTime();

        $end = new \DateTime(date("Y-m-t", strtotime("{$y}-{$m}+1month")));

        $diff = $start->diff($end);

        $json["debug"] = $diff;

        if (!$diff->invert) {
            $afterMonths = (floor($diff->days / 30));
            (new AppInvoice())->fixed($this->user, $afterMonths);
        }


        $redirect = ($data["filter"] == "income" ? "receber" : "pagar");
        $json["redirect"] = url("/app/{$redirect}/{$status}/{$category}/{$m}-{$y}");
        echo json_encode($json);

        // echo json_encode($afterMonths);
        // var_dump($start);
    }
    /**
     * APP INCOME (Receber)
     */
    /**
     * @param array|null $data
     * 
     * @return void
     */
    public function income(?array $data): void
    {
        $head = $this->seo->render(
            "Minhas receitas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $categories = (new AppCategory())
            ->find("type = :t", "t=income", "id, name")
            ->order("order_by, name")
            ->fetch(true);

        echo $this->view->render("invoices", [
            "user" => $this->user,
            "head" => $head,
            "type" => "income",
            "categories" => $categories,
            "invoices" => (new AppInvoice())->filter($this->user, "income", ($data ?? null)),
            "filter" => (object)[
                "status" => ($data["status"] ?? null),
                "category" => ($data["category"] ?? null),
                "date" => (!empty($data["date"]) ? str_replace("-", "/", $data["date"]) : null)
            ]
        ]);
    }


    /**
     * @param array|null $data
     * 
     * @return void
     */
    public function expense(?array $data): void
    {
        $head = $this->seo->render(
            "Minhas despesas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $categories = (new AppCategory())
            ->find("type = :t", "t=expense", "id, name")
            ->order("order_by, name")
            ->fetch(true);

        echo $this->view->render("invoices", [
            "user" => $this->user,
            "head" => $head,
            "type" => "expense",
            "categories" => $categories,
            "invoices" => (new AppInvoice())->filter($this->user, "expense", ($data ?? null)),
            "filter" => (object)[
                "status" => ($data["status"] ?? null),
                "category" => ($data["category"] ?? null),
                "date" => (!empty($data["date"]) ? str_replace("-", "/", $data["date"]) : null)
            ]
        ]);
    }


    /**
     * @return void
     */
    public function fixed(): void
    {
        $head = $this->seo->render(
            "Minhas contas fixas - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $whereWallet = "";
        if ((new Session())->has("walletfilter")) {
            $whereWallet = "AND wallet_id = " . (new Session())->walletfilter;
        }

        echo $this->view->render("recurrences", [
            "head" => $head,
            "invoices" => (new AppInvoice())->find(
                "user_id = :user AND type IN('fixed_income','fixed_expense') {$whereWallet}",
                "user={$this->user->id}"
            )->fetch(TRUE)
        ]);
    }

    /**
     * @param array|null $data
     * 
     * @return void
     */
    public function wallets(?array $data): void
    {
        // create
        if (!empty($data["wallet"]) && !empty($data["wallet_name"])) {
            // PREMIUM RESOURCE
            $subscribe = (new AppSubscription())->find("user_id = :user AND status != :status", "user={$this->user->id}&status=canceled");

            if (!$subscribe->count()) {
                $this->message->error("Desculpe, {$this->user->first_name}. Para criar novas carteiras é preciso ser PRO. confira abaixo.")->flash();
                echo json_encode(["redirect" => url("/app/assinatura")]);
                return;
            }


            $wallet =  new AppWallet();
            $wallet->user_id = $this->user->id;
            $wallet->wallet = htmlspecialchars($data["wallet_name"]);
            $wallet->save();

            echo json_encode(["reload" => true]);
            return;
        }

        // edit
        if (!empty($data["wallet"]) && !empty($data["wallet_edit"])) {
            $wallet = (new AppWallet())->find(
                "user_id = :user AND id = :id",
                "user={$this->user->id}&id={$data["wallet"]}"
            )->fetch();

            if ($wallet) {
                $wallet->wallet = htmlspecialchars($data["wallet_edit"]);
                $wallet->save();
            }
            echo json_encode(["wallet_edit" => true]);
            return;
        }

        // delete
        if (!empty($data["wallet"]) && !empty($data["wallet_remove"])) {
            $wallet = (new AppWallet())->find(
                "user_id = :user AND id = :id",
                "user={$this->user->id}&id={$data["wallet"]}"
            )->fetch();

            if ($wallet) {
                $wallet->destroy();
                (new Session())->unset("walletfilter");
            }
            echo json_encode(["wallet_remove" => true]);
            return;
        }


        $head = $this->seo->render(
            "Minhas carteiras - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $wallets = (new AppWallet())
            ->find("user_id = :user", "user={$this->user->id}")
            ->order("wallet")
            ->fetch(true);

        echo $this->view->render("wallets", [
            "head" => $head,
            "wallets" => $wallets
        ]);
    }

    /**
     * @param array $data
     * 
     * @return void
     */
    public function launch(array $data): void
    {

        if (request_limit("applaunch", 20, 60 * 5)) {
            $json["message"] = $this->message->warning("Foi muito rápido {$this->user->first_name}! Por favor aguarde 5 minutos para novos lançamentos.")->render();
            echo json_encode($json);
            return;
        }

        $invoice = new AppInvoice();

        $data["value"] = (!empty($data["value"]) ? str_replace([".", ","], ["", "."], $data["value"]) : 0);
        if (!$invoice->launch($this->user, $data)) {
            $json["message"] = $invoice->message()->render();
            echo json_encode($json);
            return;
        }

        $type = ($invoice->type == "income" ? "receita" : "despesa");
        $this->message->success("Tudo certo, sua {$type} foi lançada com sucesso")->flash();


        if ($invoice->type == "income") {
            $this->message->success("Receita lançada com sucesso. Use o filtro para controlar.")->render();
        } else {
            $this->message->success("Despesa lançada com sucesso. Use o filtro para controlar.")->render();
        }
        $json["reload"] = true;
        echo json_encode($json);
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function support(array $data): void
    {
        if (empty($data["message"])) {
            $json["message"] = $this->message->warning("Para enviar escreva sua mensagem.")->render();
            echo json_encode($json);
            return;
        }

        if (request_limit("appsupport", 3, 60 * 5)) {
            $json["message"] = $this->message->warning("Por favor, aguarde 5 minutos para enviar novos contatos, sugestões ou reclamações")->render();
            echo json_encode($json);
            return;
        }

        if (request_repeat("message", $data["message"])) {
            $json["message"] = $this->message->info("Já recebemos sua solicitação {$this->user->first_name}. Agradecemos pelo contato e responderemos em breve.")->render();
            echo json_encode($json);
            return;
        }

        $subject = date_fmt() . " - {$data["subject"]}";
        $message = filter_var($data["message"], FILTER_SANITIZE_STRING);

        $view = new View(__DIR__ . "/../../shared/views/email");
        $body = $view->render("mail", [
            "subject" => $subject,
            "message" => str_textarea($message)
        ]);

        (new Email())->bootstrap(
            $subject,
            $body,
            CONF_MAIL_SUPPORT,
            "Suporte " . CONF_SITE_NAME
        )->queue($this->user->email, "{$this->user->first_name} {$this->user->last_name}");

        $this->message->success("Recebemos sua solicitação {$this->user->first_name}. Agradecemos pelo contato e responderemos em breve.")->flash();
        $json["reload"] = true;
        echo json_encode($json);
    }

    /**
     * @param array $data
     * 
     * @return void
     */
    public function onpaid(array $data): void
    {

        $invoice = (new AppInvoice())
            ->find("user_id = :user AND id = :id", "user={$this->user->id}&id={$data["invoice"]}")
            ->fetch();

        if (!$invoice) {
            $this->message->error("Ooops!Ocorreu um erro ao atualizar o lançamento :/")->flash();
            $json["reload"] = true;
            echo json_encode($json);
            return;
        }


        $invoice->status = ($invoice->status == "paid" ? "unpaid" : "paid");
        $invoice->save();

        $y = date("Y");
        $m = date("m");

        if (!empty($data["date"])) {
            list($m, $y) = explode("/", $data["date"]);
        }

        $json["onpaid"] = (new AppInvoice())->balanceMonth($this->user, $y, $m, $invoice->type);

        echo json_encode($json);
    }

    /**
     * APP INVOICE (Fatura)
     */
    public function invoice(array $data): void
    {

        if (!empty($data["update"])) {
            $invoice = (new AppInvoice())
                ->find("user_id = :user AND id = :id", "user={$this->user->id}&id={$data["invoice"]}")
                ->fetch();

            if (!$invoice) {
                $json["message"] = $this->message->error("Oooops! Não foi possível carregar a fatura {$this->user->first_name}. Você pode tentar novamente")->render();
                echo json_encode($json);
                return;
            }

            if ($data["due_day"] < 1 || $data["due_day"] > $dayOfMonth = date("t", strtotime($invoice->due_at))) {
                $json["message"] = $this->message->warning("O vencimento deve ser entre dia 1 e dia {$dayOfMonth} para este mês.")->render();
                echo json_encode($json);
                return;
            }

            // $data = filter_var_array($data, HTML_SPECIALCHARS);
            $data = filter_var_array($data, FILTER_SANITIZE_SPECIAL_CHARS);


            $due_day = date("Y-m", strtotime($invoice->due_at)) . "-" . $data["due_day"];
            $invoice->category_id = $data["category"];
            $invoice->description = $data["description"];
            $invoice->due_at = date("Y-m-d", strtotime($due_day));
            $invoice->value = str_replace([".", ","], ["", "."], $data["value"]);
            $invoice->wallet_id = $data["wallet"];
            $invoice->status = $data["status"];

            if (!$invoice->save()) {
                $json["message"] = $invoice->message()->render();
                echo json_encode($json);
                return;
            }

            $invoiceOf = (new AppInvoice())->find(
                "user_id = :user AND invoice_of = :of",
                "user={$this->user->id}&of={$invoice->id}"
            )->fetch(true);

            if (!empty($invoiceOf) && in_array($invoice->type, ["fixed_income", "fixed_expense"])) {

                foreach ($invoiceOf as $invoiceItem) {
                    if ($data["status"] == "unpaid" && $invoiceItem->status == "unpaid") {
                        $invoiceItem->destroy();
                    } else {
                        $due_day = date("Y-m", strtotime($invoiceItem->due_at)) . "-" . $data["due_day"];
                        $invoiceItem->category_id = $data["category"];
                        $invoiceItem->description = $data["description"];
                        $invoiceItem->wallet_id = $data["wallet"];

                        if ($invoiceItem->status == "unpaid") {
                            $invoiceItem->value = str_replace([".", ","], ["", "."], $data["value"]);
                            $invoiceItem->due_at = date("Y-m-d", strtotime($due_day));
                        }
                        $invoiceItem->save();
                    }
                }
            }

            $json["message"] = $this->message->success("Pronto, {$this->user->first_name}. A atualização foi efetuada com sucesso!")->render();
            echo json_encode($json);
            return;
        }

        $head = $this->seo->render(
            "Aluguel - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        $invoice = (new AppInvoice())
            ->find(
                "user_id=:user AND id = :invoice",
                "user={$this->user->id}&invoice={$data["invoice"]}"
            )
            ->fetch();

        if (!$invoice) {
            $this->message->error("Ooops, você tentou acessar uma fatura que não existe")->flash();
            redirect("/app");
        }

        echo $this->view->render("invoice", [
            "head" => $head,
            "invoice" => $invoice,
            "wallets" => (new AppWallet())
                ->find("user_id = :user", "user={$this->user->id}", "id, wallet")
                ->order('wallet')
                ->fetch(true),
            "categories" => (new AppCategory())
                ->find("type = :type", "type={$invoice->category()->type}")
                ->order("order_by")
                ->fetch(true)
        ]);
    }


    /**
     * @param array $data
     * 
     * @return void
     */
    public function remove(array $data): void
    {
        $invoice = (new AppInvoice())->find(
            "user_id = :user AND id = :invoice",
            "user={$this->user->id}&invoice={$data["invoice"]}"
        )->fetch();



        if ($invoice) {
            $invoice->destroy();
        }

        $this->message->success("Tudo pronto, {$this->user->first_name}. O lançamento foi removido com sucesso!")->flash();
        $json["redirect"] = url("/app");
        echo json_encode($json);
    }

    /**
     * APP PROFILE (Perfil)
     */
    /**
     * @param array|null $data
     * 
     * @return void
     */
    public function profile(?array $data): void
    {
        if (!empty($data["update"])) {

            list($d, $m, $y) = explode("/", $data["datebirth"]);
            $user = (new user())->findById($this->user->id);
            $user->first_name = $data["first_name"];
            $user->last_name = $data["last_name"];
            $user->genre = $data["genre"];
            $user->dateBirth = "{$y}-{$m}-{$d}";
            $user->document = preg_replace("/[^0-9]/", "", $data["document"]);

            if (!empty($_FILES["photo"])) {
                $file = $_FILES["photo"];
                $upload = new Upload();
                if ($this->user->photo()) {
                    (new Thumb())->flush("storage/{$this->user->photo}");
                    $upload->remove("storage/{$this->user->photo}");
                }

                if (!$user->photo = $upload->image($file, "{$user->first_name} {$user->last_name}" . time(), 360)) {
                    $json["message"] = $upload->message()->before("Ooops {$this->user->first_name}!")->after(".")->render();
                    echo json_encode($json);
                    return;
                }
            }

            if (!empty($data["password"])) {
                if (empty($data["password_re"]) || $data["password"] != $data["password_re"]) {
                    $json["message"] = $this->message->warning("Para alterar sua senha, informe e repit a nova senha!")->render();
                    echo json_encode($json);
                    return;
                }
                $user->password = $data["password"];
            }

            if (!$user->save()) {
                $json["message"] = $user->message()->render();
                echo json_encode($json);
                return;
            }

            $json["message"] = $this->message->success("Pronto, {$this->user->first_name}.Seus dados foram atualiados com sucesso")->render();
            echo json_encode($json);
            return;

            // $json["data"] = $user->data();
            // echo json_encode($json);
            // return;
        }

        $head = $this->seo->render(
            "Meu perfil - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("profile", [
            "head" => $head,
            "user" => $this->user,
            "photo" => ($this->user->photo() ? image($this->user->photo, 360, 360) : theme("/assets/images/avatar.jpg", CONF_VIEW_APP))
        ]);
    }

    public function signature(?array $data): void
    {
        $head = $this->seo->render(
            "Assinatura - " . CONF_SITE_NAME,
            CONF_SITE_DESC,
            url(),
            theme("/assets/images/share.jpg"),
            false
        );

        echo $this->view->render("signature", [
            "head" => $head,
            "subscription" => (new AppSubscription())
                ->find("user_id = :user AND status != :status", "user={$this->user->id}&status=canceled")
                ->fetch(),
            "orders" => (new AppOrder())
                ->find("users_id = :user", "user={$this->user->id}")
                ->order("created_at DESC")
                ->fetch(true),
            "plans" => (new AppPlan())->find("status= :status", "status=active")
                ->order("name, price")
                ->fetch(true)
        ]);
    }

    /**
     * APP LOGOUT
     */
    public function logout()
    {
        (new Message())->info("Você saiu com sucesso " . Auth::user()->first_name . ". Volte logo :)")->flash();

        Auth::logout();
        redirect("/entrar");
    }
}
