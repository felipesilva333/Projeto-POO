<?php

session_start();

class BarberController extends RenderView
{
    public function save()
    {
        if (isset($_POST['id']) and !empty($_POST['id'])) {
            $this->edit();
            exit;
        }

        $this->create();
    }

    public function create()
    {
        $barber = new BarberModel();
        $name = $_POST['name'];

        if ($barber->fetchByName($name)) {
            echo json_encode([
                "status" => 401,
                "message" => "Barbeiro já cadastrado!",
            ]);

            exit;
        }

        try {
            $barber->create($name);
            echo json_encode([
                "status" => 200,
                "message" => "Barbeiro adicionado com sucesso!",
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                "status" => 500,
                "message" => $th->getMessage(),
            ]);
        }
    }


    public function edit()
    {
        $barber = new BarberModel();

        $barber = $_POST['name'];
        $id = $_POST['id'];

        try {
            $barber->update($name,$id);
            echo json_encode([
                "status" => 200,
                "message" => "Dados do barbeiro atualizado com sucesso!",
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                "status" => 500,
                "message" => $th->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        $barber = new BarberModel();

        try {
            $barber->delete($id[0]);
            echo json_encode([
                "status" => 200,
                "message" => "Barbeiro deletado com sucesso!",
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                "status" => 500,
                "message" => $th->getMessage(),
            ]);
        }
    }

    public function getAllBarbers()
    {
        $barber = new BarberModel();

        try {
            $allBarbers = $barber->allBarbers();
            echo json_encode([
                "status" => 200,
                "message" => "Busca de informações de contato concluída com sucesso",
                "data" => $allBarbers
            ]);
        } catch (\Throwable $th) {
            echo json_encode([
                "status" => 500,
                "message" => $th->getMessage()
            ]);
        }
    }
}
