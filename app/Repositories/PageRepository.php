<?php

namespace App\Repositories;

use App\Http\Libraries\Helpers;
use App\Models\Page;
use Exception;


class PageRepository
{
    protected $pages;

    public function __construct(Page $pages)
    {
        $this->pages = $pages;
    }

    public function all()
    {
        return $this->pages->get();
    }

    public function create($attributes)
    {
        if ($attributes) {
//            if (isset($attributes['banner_image'])) {
//                $logo = (new Helpers())->uploadFile($attributes['banner_image'], 'pages');
//            }
            try {
                $return = $this->pages->create([
                    'title' => ($attributes['title']) ?: '',
//                    'banner_image' => ($logo) ?: '',
                    'meta_title' => ($attributes['meta_title']) ?: '',
                    'meta_keywords' => ($attributes['meta_keywords']) ?: '',
                    'meta_description' => ($attributes['meta_description']) ?: '',
//                    'content' => ($attributes['content']) ?: '',
                    'is_disabled' => (isset($attributes['is_disabled']) ? (int)$attributes['is_disabled'] : 0),
                ]);
                return redirect()->route('pages.index')->with(['success' => 'Page Created Successfully..!']);
            } catch (Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong....!']);
        }
    }

    public function edit($slug)
    {
        return $this->pages->whereSlug($slug)->first();
    }

    public function update($attributes)
    {
//        dd($attributes);
        if ($attributes) {
            try {
                $this->pages->where('id', $attributes['pageId'])->update([]);
                $return = $this->pages->create([
                    'title' => ($attributes['title']) ?: '',
//                    'banner_image' => ($logo) ?: '',
                    'meta_title' => ($attributes['meta_title']) ?: '',
                    'meta_keywords' => ($attributes['meta_keywords']) ?: '',
                    'meta_description' => ($attributes['meta_description']) ?: '',
//                    'content' => ($attributes['content']) ?: '',
                    'is_disabled' => (isset($attributes['is_disabled']) ? (int)$attributes['is_disabled'] : 0),
                ]);
                return redirect()->route('pages.index')->with(['success' => 'Page Created Successfully..!']);
            } catch (Exception $e) {
                return redirect()->back()->with(['error' => $e->getMessage()]);
            }
        } else {
            return redirect()->back()->with(['error' => 'Something went wrong....!']);
        }
    }

    public function delete($id)
    {
    }
}
