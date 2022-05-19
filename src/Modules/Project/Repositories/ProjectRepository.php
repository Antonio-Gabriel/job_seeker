<?php

namespace SpeackWithUs\Modules\Project\Repositories;

use SpeackWithUs\Config\Db\Sql;
use SpeackWithUs\Modules\Project\Entities\Dto\ProjectProps;
use SpeackWithUs\Modules\Project\Interfaces\IProjectRepository;

class ProjectRepository implements IProjectRepository
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
             p.id , p.referencia , p.nome , 
             c.nome  as categoria, p.habilidades 
             ,p.preco, p.descricao,
             p.data_inicio , p.data_fim 
             FROM tb_projecto p 
             INNER JOIN tb_categoria  c 
             ON p.categoria_id = c.id"
        );
    }

    public function getById(int $id)
    {
        return $this->sql->select(
            "SELECT 
             p.id , p.referencia , p.nome , 
             c.nome  as categoria, p.habilidades 
             ,p.preco, p.descricao,
             p.data_inicio , p.data_fim 
             FROM tb_projecto p 
             INNER JOIN tb_categoria  c 
             ON p.categoria_id = c.id
             WHERE p.id = :id",
            [
                ":id" => $id
            ]
        );
    }

    public function findByReference(string $reference)
    {
        return $this->sql->select(
            "SELECT *FROM tb_projecto WHERE referencia = :reference",
            [
                ":reference" => $reference
            ]
        );
    }

    public function filterByName(string $name)
    {
        $search = "%{$name}%";

        return $this->sql->select(
            "SELECT 
             p.id , p.referencia , p.nome , 
             c.nome  as categoria, p.habilidades , 
             p.preco, p.descricao,
             p.data_inicio , p.data_fim 
             FROM tb_projecto p 
             INNER JOIN tb_categoria  c 
             ON p.categoria_id = c.id 
             WHERE p.nome LIKE :name",
            [
                ":name" => $search
            ]
        );
    }

    public function filterByReference(string $reference)
    {
        $search = "%{$reference}%";

        return $this->sql->select(
            "SELECT 
             p.id , p.referencia , p.nome , 
             c.nome  as categoria, p.preco, 
             p.data_inicio , p.data_fim 
             FROM tb_projecto p 
             INNER JOIN tb_categoria  c 
             ON p.categoria_id = c.id 
             WHERE p.referencia LIKE :referencia",
            [
                ":referencia" => $search
            ]
        );
    }

    public function create(ProjectProps $props)
    {
        $statement = $this->sql->query(
            "INSERT INTO tb_projecto (referencia, categoria_id, nome, descricao, habilidades, preco, data_inicio, data_fim) 
             VALUES (:referencia, :categoria_id, :nome, :descricao, :habilidades, :preco, :data_inicio, :data_fim);",
            [
                ":referencia" => $props->reference,
                ":categoria_id" => $props->categoryId,
                ":nome" => $props->name,
                ":descricao" => $props->description,
                ":habilidades" => $props->habilities,
                ":preco" => $props->price,
                ":data_inicio" => $props->createdAt,
                ":data_fim" => $props->finishedAt
            ]
        );

        return $statement;
    }

    public function update(ProjectProps $props, int $id)
    {
        $statement = $this->sql->query(
            "UPDATE tb_projecto SET              
             referencia = :referencia, categoria_id = :categoria_id, 
             nome = :nome, descricao = :descricao, habilidades = :habilidades, 
             preco = :preco, data_inicio = :data_inicio, data_fim = :data_fim
             WHERE id = :id",
            [
                ":id" => $id,
                ":referencia" => $props->reference,
                ":categoria_id" => $props->categoryId,
                ":nome" => $props->name,
                ":descricao" => $props->description,
                ":habilidades" => $props->habilities,
                ":preco" => $props->price,
                ":data_inicio" => $props->createdAt,
                ":data_fim" => $props->finishedAt
            ]
        );

        return $statement;
    }

    public function delete(int $id)
    {
        $statement = $this->sql->query(
            "DELETE FROM tb_projecto WHERE id = :id",
            [
                ":id" => $id
            ]
        );

        return $statement;
    }
}
