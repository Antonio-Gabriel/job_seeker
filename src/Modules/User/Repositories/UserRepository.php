<?php

namespace SpeackWithUs\Modules\User\Repositories;

use SpeackWithUs\Config\Db\Sql;
use SpeackWithUs\Modules\User\Entities\Dto\UserProps;
use SpeackWithUs\Modules\User\Interfaces\IUserRepository;

class UserRepository implements IUserRepository
{
    private Sql $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function get()
    {
        return $this->sql->select(
            "SELECT 
             u.id , u.nome , u.numero, u.cidade, u.cidade,
             u.bairro, c.cargo ,u.rua, u.email, u.admin, u.estado,
             c.palavrapasse, c.imagem 
             FROM tb_usuario u 
             INNER JOIN tb_conta c 
             ON c.usuario_id = u.id "
        );
    }

    public function getById(int $id)
    {
        return $this->sql->select(
            "SELECT 
             u.id , u.nome , u.numero, u.cidade, u.cidade,
             u.bairro, u.rua, u.email, u.admin, u.estado,
             c.palavrapasse, c.imagem 
             FROM tb_usuario u 
             INNER JOIN tb_conta c 
             ON c.usuario_id = u.id 
             WHERE u.id = :id",
            [
                ":id" => $id
            ]
        );
    }

    public function getAccountId(int $id)
    {
        return $this->sql->select(
            "SELECT 
             u.id , u.nome , u.numero, u.cidade,
             u.bairro, u.rua, u.email, u.admin, u.estado,
             c.palavrapasse, c.imagem , c.cargo, c.descricao, 
             d.github as gitHub, d.linked_in as linkedIn, 
             d.portofolio, h.desc_habilidades as habilidades
             FROM tb_usuario u 
             INNER JOIN tb_conta c 
             ON c.usuario_id = u.id  
             INNER JOIN tb_dominio d
             ON d.usuario_id = u.id        
             INNER JOIN tb_habilidade h
             ON h.usuario_id = u.id
             WHERE u.id = :id",
            [
                ":id" => $id
            ]
        );
    }

    public function filterByName(string $name)
    {
        $search = "%{$name}%";

        return $this->sql->select(
            "SELECT 
             u.id , u.nome , u.numero, u.cidade,
             u.bairro, u.rua, u.email, u.admin, u.estado,
             c.palavrapasse, c.imagem
             FROM tb_usuario u 
             INNER JOIN tb_conta c 
             ON c.usuario_id = u.id               
             WHERE u.nome LIKE :name",
            [
                ":name" => $search
            ]
        );
    }

    public function findByEmail(string $email)
    {
        return $this->sql->select(
            "SELECT 
             u.id , u.nome , u.numero, u.cidade,
             u.bairro, u.rua, u.email, u.admin, u.estado,
             c.palavrapasse, c.imagem , c.descricao, c.cargo
             FROM tb_usuario u 
             INNER JOIN tb_conta c 
             ON c.usuario_id = u.id               
             WHERE u.email = :email",
            [
                ":email" => $email
            ]
        );
    }

    public function create(UserProps $props)
    {
        $statement = $this->sql->query(
            "INSERT INTO tb_usuario (nome, numero, cidade, bairro, rua, email, admin, estado) 
             VALUES (:nome, :numero, :cidade, :bairro, :rua, :email, :admin, :estado);",
            [
                ":nome" => $props->name,
                ":numero" => $props->phone,
                ":cidade" => $props->city,
                ":bairro" => $props->district,
                ":rua" => $props->road,
                ":email" => $props->email,
                ":admin" => $props->admin,
                ":estado" => $props->state
            ]
        );

        return $this->sql->select("SELECT last_insert_id() as 'id';")[0]["id"];;
    }

    public function updateUserState(int $id, int $state)
    {
        $statement = $this->sql->query(
            "UPDATE tb_usuario SET estado = :estado
             WHERE id = :id",
            [
                ":id" => $id,
                ":estado" => $state
            ]
        );

        return $statement;
    }

    public function update(UserProps $props, int $id)
    {
        $statement = $this->sql->query(
            "UPDATE tb_usuario SET              
             nome = :nome, numero = :numero, 
             cidade = :cidade, bairro = :bairro, rua = :rua, 
             email = :email, admin = :admin, estado = :estado
             WHERE id = :id",
            [
                ":id" => $id,
                ":nome" => $props->name,
                ":numero" => $props->phone,
                ":cidade" => $props->city,
                ":bairro" => $props->district,
                ":rua" => $props->road,
                ":email" => $props->email,
                ":admin" => $props->admin,
                ":estado" => $props->state
            ]
        );

        return $statement;
    }

    public function delete(int $id)
    {
        $statement = $this->sql->query(
            "DELETE FROM tb_usuario WHERE id = :id",
            [
                ":id" => $id
            ]
        );

        return $statement;
    }
}
