<?php

session_start();

class ScheduleController extends RenderView
{
    public function index()
    {
        $isLogged = isset($_SESSION['user']);
        $isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'];

        if (!$isLogged) {
            header('Location: ' . BASE_URL . 'login?redirect=schedule');
            exit;
        }

        if ($isAdmin) {
            header('Location: ' . BASE_URL . 'admin');
            exit;
        }

        $contactInfo = new ContactInfoModel();
        $service = new ServiceModel();
        $barberModel = new BarberModel();

        $allServices = $service->allServices();
        $allContactInfos = $contactInfo->allContactInfos()[0] ?? null;
        $allBarbers = $barberModel->allBarbers();

        $this->loadView('templates/head', [
            'title' => 'Agendamento',
            'scripts' => [
                BASE_URL . "public/js/pages/schedule.js"
            ]
        ]);
        $this->loadView('templates/header', [
            'isAuth' => isset($_SESSION['user']),
            'isAdm'  => isset($_SESSION['user']) && $_SESSION['isAdmin'],
        ]);
        $this->loadView('schedule', [
            'services' => $allServices,
            'barbers' => $allBarbers,
            'userData' => $_SESSION['user'] ?? [],
        ]);
        $this->loadView('templates/footer', [
            'contact_info' => $allContactInfos,
            'isAuth' => isset($_SESSION['user']),
            'isAdm'  => isset($_SESSION['user']) && $_SESSION['isAdmin'],
        ]);
    }

    public function create()
    {
        if (empty($_POST)) {
            echo json_encode([
                "status" => 400,
                "message" => "Erro: Nenhum dado foi enviado!"
            ]);
            exit();
        }

        if (!isset($_POST["barber"])) {
            echo json_encode([
                "status" => 400,
                "message" => "Erro: Barber ID não foi enviado!"
            ]);
            exit();
        }

        $schedule = new ScheduleModel();

        $user = $_POST["username"];
        $tel = $_POST["tel"];
        $email = $_POST["email"];
        $barber_id = $_POST["barber"];
        $service_id = $_POST["service"];
        $datetime = $_POST["datetime"];
        $message = $_POST["message"];
        $user_id = $_POST["user_id"];

        // 🚨 Verificar se o horário já está ocupado para o barbeiro escolhido
        if ($schedule->isDatetimeTaken($datetime, $barber_id)) {
            echo json_encode([
                "status" => 401,
                "message" => "Este horário já está reservado para outro cliente. Escolha outro horário.",
            ]);
            exit();
        }

        try {
            $schedule->create($user, $tel, $email, $barber_id, $service_id, $datetime, $message, $user_id);
            echo json_encode([
                "status" => 200,
                "message" => "Agendamento realizado com sucesso!",
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                "status" => 500,
                "message" => "Erro ao criar o agendamento: " . $th->getMessage(),
            ]);
        }
    }

    public function updateStatus()
    {
        $status = $_POST["status"];
        $id = $_POST["id"];

        $schedule = new ScheduleModel();

        try {
            $schedule->updateStatus($status, $id);
            echo json_encode([
                "status" => 200,
                "message" => "Status atualizado com sucesso!",
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                "status" => 500,
                "message" => $th->getMessage()
            ]);
        }
    }

    public function getAllSchedules()
    {
        $schedule = new ScheduleModel();

        try {
            $allSchedules = $schedule->allSchedules();
            echo json_encode([
                "status" => 200,
                "message" => "Busca de agendamentos concluída com sucesso",
                "data" => $allSchedules
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                "status" => 500,
                "message" => $th->getMessage()
            ]);
        }
    }

    public function getSchedulesByUser()
    {
        $schedule = new ScheduleModel();

        try {
            $userSchedules = $schedule->fetchByUser($_SESSION['user']['id']);
            echo json_encode([
                "status" => 200,
                "message" => "Busca de agendamentos concluída com sucesso",
                "data" => $userSchedules
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                "status" => 500,
                "message" => $th->getMessage()
            ]);
        }
    }
}
