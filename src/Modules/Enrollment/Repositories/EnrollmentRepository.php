<?php

namespace SpeackWithUs\Modules\Enrollment\Repositories;

use SpeackWithUs\Config\Db\Sql;
use SpeackWithUs\Modules\Enrollment\Interfaces\IEnrollmetRepository;

class EnrollmentRepository implements IEnrollmetRepository
{
    private Sql $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function applyToWork(int $projectId, int $userId)
    {
        $statement = $this->sql->query(
            "INSERT INTO tb_usuario_projecto (projecto_id, usuario_id, data_cadastro, estado_do_projecto) 
             VALUES (:projecto_id, :usuario_id, now(), :estado_do_projecto)",
            [
                ":projecto_id" => $projectId,
                ":usuario_id" => $userId,
                ":estado_do_projecto" => "Pendente"
            ]
        );

        return $statement;
    }

    public function approvedToWork(int $projectId, int $userId)
    {
        $statement = $this->sql->query(
            "UPDATE tb_usuario_projecto SET estado_do_projecto = :estado_do_projecto
             WHERE projecto_id = :projecto_id AND usuario_id = :usuario_id",
            [
                ":projecto_id" => $projectId,
                ":usuario_id" => $userId,
                ":estado_do_projecto" => "Processando"
            ]
        );

        return $statement;
    }

    public function getEnrollments(int $userid)
    {
        return $this->sql->select(
            "SELECT 
             u.nome as username, u.email ,
             p.nome  as project, p.referencia ,
             p.descricao , p.preco , p.data_inicio ,
             p.data_fim , up.estado_do_projecto 
             FROM tb_usuario_projecto up
             INNER JOIN tb_projecto p
             ON up.projecto_id = p.id
             INNER JOIN tb_usuario u
             ON up.usuario_id = u.id
             WHERE u.id = :id;
            
            ",
            [
                ":id" => $userid
            ]
        );
    }

    public function getAllEnrollments()
    {
        return $this->sql->select(
            "SELECT 
             up.projecto_id ,
             up.usuario_id ,
             u.nome as nome_usuario, u.email,
             p.nome as nome_projecto, p.referencia,
             h.desc_habilidades, up.estado_do_projecto
             FROM tb_usuario_projecto up
             INNER JOIN tb_usuario u 
             ON up.usuario_id = u.id 
             INNER JOIN tb_projecto p
             ON up.projecto_id = p.id 
             INNER JOIN tb_habilidade h
             ON u.id = h.usuario_id"
        );
    }

    public function getEnrollmentsByCategory(int $categoryId)
    {
        return $this->sql->select(
            "SELECT 
             up.projecto_id ,
             up.usuario_id ,
             u.nome as nome_usuario, u.email,
             p.nome as nome_projecto, p.referencia,
             h.desc_habilidades, up.estado_do_projecto
             FROM tb_usuario_projecto up
             INNER JOIN tb_usuario u 
             ON up.usuario_id = u.id 
             INNER JOIN tb_projecto p
             ON up.projecto_id = p.id 
             INNER JOIN tb_habilidade h
             ON u.id = h.usuario_id
             WHERE p.categoria_id = :category",
            [
                ":category" => $categoryId
            ]
        );
    }

    public function findBySubscribeJob(int $projectId, int $userId)
    {
        return $this->sql->select(
            "SELECT * FROM tb_usuario_projecto             
             WHERE projecto_id = :projecto_id AND usuario_id = :usuario_id;
            ",
            [
                ":projecto_id" => $projectId,
                ":usuario_id" => $userId
            ]
        );
    }
}
