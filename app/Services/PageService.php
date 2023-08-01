<?php

namespace App\Services;

use App\Repositories\PageRepository;

class PageService
{
    public function __construct(PageRepository $pageRepository)
    {
        $this->page = $pageRepository;
    }

    public function index()
    {
        return $this->page->all();
    }

    public function create($attributes)
    {
        return $this->page->create($attributes);
    }

    public function edit($slug)
    {
        return $this->page->edit($slug);
    }

    public function update($data)
    {
        return $this->page->update($data);
    }

    public function delete($id)
    {
        return $this->page->delete($id);
    }
}
