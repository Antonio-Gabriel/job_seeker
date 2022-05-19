<?php

namespace SpeackWithUs\Modules\Category\Repositories;

use SpeackWithUs\Config\Db\Sql;
use SpeackWithUs\Modules\Category\Entities\Dto\CategoryProps;
use SpeackWithUs\Modules\Category\Interfaces\ICategoryRepository;

class CategoryRepository implements ICategoryRepository
{
    private Sql $sql;

    public function __construct()
    {
        $this->sql = new Sql();
    }

    public function get()
    {
        return $this->sql->select(
            "SELECT *FROM tb_categoria"
        );
    }

    public function getById(int $id)
    {
        return $this->sql->select(
            "SELECT *FROM tb_categoria WHERE id = :id",
            [
                ":id" => $id
            ]
        );
    }

    public function findByName(string $name)
    {
        return $this->sql->select(
            "SELECT *FROM tb_categoria WHERE nome = :name",
            [
                ":name" => $name
            ]
        );
    }

    public function filterByName(string $name)
    {
        $search = "%{$name}%";

        return $this->sql->select(
            "SELECT *FROM tb_categoria WHERE nome LIKE :name",
            [
                ":name" => $search
            ]
        );
    }

    public function create(CategoryProps $props)
    {
        $statement = $this->sql->query(
            "INSERT INTO tb_categoria (nome, estado) VALUES (:name, :state)",
            [
                ":name" => $props->name,
                ":state" => ($props->state == 1 ? 1 : 0)
            ]
        );

        return $statement;
    }

    public function update(CategoryProps $props, int $id)
    {
        $statement = $this->sql->query(
            "UPDATE tb_categoria SET nome = :name, estado = :state WHERE id = :id",
            [
                ":id" => $id,
                ":name" => $props->name,
                ":state" => ($props->state == 1 ? 1 : 0)
            ]
        );

        return $statement;
    }

    public function delete(int $id)
    {
        $statement = $this->sql->query(
            "DELETE FROM tb_categoria WHERE id = :id",
            [
                ":id" => $id
            ]
        );

        return $statement;
    }
}
