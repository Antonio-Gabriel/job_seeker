<?php

namespace SpeackWithUs\Modules\Account\Repositories;

use SpeackWithUs\Config\Db\Sql;
use SpeackWithUs\Modules\Account\Entities\Dto\AccountProps;
use SpeackWithUs\Modules\Account\Interfaces\IAccountRepository;

class AccountRepository implements IAccountRepository
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
             c.id , u.id as usuario_id, u.nome , u.numero, 
             u.cidade, u.bairro, u.rua, u.email, u.admin, 
             u.estado, c.palavrapasse, c.imagem 
             FROM
             tb_conta c
             INNER JOIN tb_usuario u
             ON c.usuario_id = u.id 
            "
        );
    }

    public function getById(int $id)
    {
        return $this->sql->select(
            "SELECT 
             c.id , u.id as usuario_id, u.nome , u.numero, 
             u.cidade, u.bairro, u.rua, u.email, u.admin, 
             u.estado, c.palavrapasse, c.imagem 
             FROM
             tb_conta c
             INNER JOIN tb_usuario u
             ON c.usuario_id = u.id WHERE c.id = :id 
            ",
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
             u.id , u.nome , u.numero, u.cidade, u.cidade,
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

    public function create(AccountProps $props)
    {
        $statement = $this->sql->query(
            "INSERT INTO tb_conta (usuario_id, palavrapasse, imagem, cargo, descricao) 
             VALUES (:usuario_id, :palavrapasse, :imagem, :cargo, null);",
            [
                ":usuario_id" => $props->userId,
                ":palavrapasse" => $props->password,
                ":imagem" => $props->image,
                ":cargo" => $props->area
            ]
        );

        return $statement;
    }

    public function update(AccountProps $props, int $id)
    {
        $statement = $this->sql->query(
            "UPDATE tb_conta SET              
             palavrapasse = :palavrapasse, imagem = :imagem, 
             cargo = :cargo WHERE id = :id",
            [
                ":id" => $id,
                ":palavrapasse" => $props->password,
                ":imagem" => $props->image,
                ":cargo" => $props->area
            ]
        );

        return $statement;
    }

    public function delete(int $id)
    {
        $statement = $this->sql->query(
            "DELETE FROM tb_conta WHERE id = :id",
            [
                ":id" => $id
            ]
        );

        return $statement;
    }

    public function updateAccountBulk(array ...$args)
    {
        $findExistentDomain = $this->sql->select(
            "SELECT *FROM tb_dominio WHERE usuario_id = :id",
            [
                ":id" => intval($args[0]["id"])
            ]
        );

        if (
            !$findExistentDomain
        ) {
            $accountStatement = $this->sql->query(
                "UPDATE tb_conta SET cargo = :cargo, descricao = :descricao WHERE usuario_id = :id",
                [
                    ":cargo" => $args[0]["cargo"],
                    ":descricao" => trim($args[0]["descricao"]),
                    ":id" => intval($args[0]["id"])
                ]
            );

            if ($accountStatement) {

                $userStatement = $this->sql->query(
                    "UPDATE tb_usuario SET              
                     nome = :nome, numero = :numero, 
                     cidade = :cidade, bairro = :bairro, rua = :rua, 
                     email = :email, admin = :admin, estado = :estado
                     WHERE id = :id",
                    [
                        ":id" => intval($args[0]["id"]),
                        ":nome" => $args[0]["nome"],
                        ":numero" => $args[0]["numero"],
                        ":cidade" => $args[0]["cidade"],
                        ":bairro" => $args[0]["bairro"],
                        ":rua" => $args[0]["rua"],
                        ":email" => $args[0]["email"],
                        ":admin" => 0,
                        ":estado" => 1
                    ]
                );

                if ($userStatement) {

                    $domainStatement = $this->sql->query(
                        "INSERT INTO tb_dominio (usuario_id, github, linked_in, portofolio) 
                         VALUES (:usuario_id, :github, :linked_in, :portofolio)",
                        [
                            ":usuario_id" => intval($args[0]["id"]),
                            ":github" => $args[0]["gitHub"],
                            ":linked_in" => $args[0]["linkedIn"],
                            ":portofolio" => $args[0]["portofolio"]
                        ]
                    );

                    if ($domainStatement) {

                        $habilitiesStatement = $this->sql->query(
                            "INSERT INTO tb_habilidade (usuario_id, desc_habilidades) 
                             VALUES (:usuario_id, :desc_habilidades)",
                            [
                                ":usuario_id" => intval($args[0]["id"]),
                                ":desc_habilidades" => trim($args[0]["habilidades"])
                            ]
                        );

                        if ($habilitiesStatement) {
                            return $args;
                        }
                    }
                }
            }
        } else {
            $accountStatement = $this->sql->query(
                "UPDATE tb_conta SET cargo = :cargo, descricao = :descricao WHERE usuario_id = :id",
                [
                    ":cargo" => $args[0]["cargo"],
                    ":descricao" => trim($args[0]["descricao"]),
                    ":id" => intval($args[0]["id"])
                ]
            );

            if ($accountStatement) {

                $userStatement = $this->sql->query(
                    "UPDATE tb_usuario SET              
                     nome = :nome, numero = :numero, 
                     cidade = :cidade, bairro = :bairro, rua = :rua, 
                     email = :email, admin = :admin, estado = :estado
                     WHERE id = :id",
                    [
                        ":id" => intval($args[0]["id"]),
                        ":nome" => $args[0]["nome"],
                        ":numero" => $args[0]["numero"],
                        ":cidade" => $args[0]["cidade"],
                        ":bairro" => $args[0]["bairro"],
                        ":rua" => $args[0]["rua"],
                        ":email" => $args[0]["email"],
                        ":admin" => 0,
                        ":estado" => 1
                    ]
                );

                if ($userStatement) {

                    $domainStatement = $this->sql->query(
                        "UPDATE tb_dominio SET github = :github, linked_in = :linked_in, portofolio = :portofolio
                         WHERE usuario_id = :usuario_id",
                        [
                            ":usuario_id" => intval($args[0]["id"]),
                            ":github" => $args[0]["gitHub"],
                            ":linked_in" => $args[0]["linkedIn"],
                            ":portofolio" => $args[0]["portofolio"]
                        ]
                    );

                    if ($domainStatement) {

                        $habilitiesStatement = $this->sql->query(
                            "UPDATE tb_habilidade SET usuario_id = :usuario_id, desc_habilidades = :desc_habilidades",
                            [
                                ":usuario_id" => intval($args[0]["id"]),
                                ":desc_habilidades" => trim($args[0]["habilidades"])
                            ]
                        );

                        if ($habilitiesStatement) {
                            return $args;
                        }
                    }
                }
            }
        }
    }
}
