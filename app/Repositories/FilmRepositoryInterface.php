<?php
namespace App\Repositories;

interface FilmRepositoryInterface
{
    public function all();

    public function store($data);

    public function show($id);
}
?>
