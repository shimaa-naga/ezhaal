<?php

namespace App\Help;

use App\Models\Projects\ProjCategories;
use App\Models\Projects\ProjcategoryAttributes;
use App\Models\Projects\ProjCategoryData;

class Category
{
    private  $separator1 = "|";
    private  $separator2 = "&rarr;";
    public $publish = null;
    public $without_parents = false;
    private  $collect = [];
    private $parents = [];

    // private static function getCategoryRecursive($category, $type = "dropdown")
    // {
    //     $html = "";
    //     if ($type == "dropdown")
    //         $html .= '<li>';
    //     else
    //         $html .= self::$separator;
    //     $html  .= $category->DataWithLang()->title;
    //     if ($category->children()->count() != 0) {
    //         if ($type == "dropdown")
    //             $html .= '<ul>';
    //         foreach ($category->children() as $child) {

    //             $html .= self::getCategoryRecursive($child);
    //         }
    //         if ($type == "dropdown")

    //             $html .= '</ul>';
    //     }
    //     if ($type == "dropdown")
    //         $html .= '</li>';
    //     return $html;
    // }

    public function getParentList()
    {
        return $this->parents;
    }
    private  function getCategoryRecursiveArray($category, $depth = 1)
    {
        $html = "";
        $html .= $this->separator1 . str_repeat($this->separator2, $depth); //.self::$separator;
        $html  .= $category->DataWithLang()->title;


        if (($this->without_parents && $depth == 1)) {
            // $this->collect[] = ["title" => "---", "text" => "---", "id" => "", "imageUrl" => asset("uploads/category/cat.png")];
        } else
            $this->collect[] = ["title" => $html, "text" => $html, "id" => $category->id, "imageUrl" => asset("uploads/category/cat.png")];


        if ($category->children()->count() != 0) {
            foreach ($category->children() as $child) {
                if ($this->publish != null) {
                    if ($child->published == $this->publish) {
                        $depth++;
                        $html .= $this->getCategoryRecursiveArray($child, $depth);
                        $collect[] = ["title" => $html, "text" => $html, "id" => $child->id, "imageUrl" => asset("uploads/category/cat.png")];
                    }
                } else {
                    $depth++;
                    $html .= $this->getCategoryRecursiveArray($child, $depth);
                    $collect[] = ["title" => $html, "text" => $html, "id" => $child->id, "imageUrl" => asset("uploads/category/cat.png")];
                }
            }
        }

        return $html;
    }
    public  static function UpdateRecursive($category, $options)
    {
        $category->update($options);
        if ($category->children()->count() != 0) {
            foreach ($category->children() as $child) {
                $child->update($options);
                self::UpdateRecursive($child, $options);
            }
        }
    }
    private  function getParents($type)
    {
        $collection = ProjCategories::whereNull('parent_id');

        // if ($type != null)
        //     $collection = $collection->where("type", $type);
        if ($this->publish != null)
            $collection->where("published", $this->publish);
        $result = $collection->get();
        if ($this->without_parents == true) {
            $this->parents = $result;
        }
        return $result;
    }
    // public static function dropdownTree()
    // {

    //     echo "<ul>";
    //            foreach (self::getParents() as $category) {

    //         echo self::getCategoryRecursive($category);
    //     }
    //     echo "</ul>";
    // }
    // public static function selectTree()
    // {
    //     $html = "";
    //     foreach (self::getParents() as $category) {

    //         $html .= self::getCategoryRecursive($category, "tree");
    //     }
    //     return $html;
    // }
    /**
     *
     */

    public  function selectTreeArray($type = "project")
    {

        $result = ProjCategories::join("projcategory_attributes", "projcategories.id", "projcategory_attributes.category_id")->where("projcategory_attributes.module", $type)->select("projcategories.id", "projcategories.parent_id", "projcategories.scope")->where("published", 1)->get();

        foreach ($this->getParents("") as $category) {

            $this->getCategoryRecursiveArray($category);
        }
        //dd($this->collect);

        return $this->collect;
        //   $result=  ProjCategories::join("projcategory_attributes","projcategories.id","projcategory_attributes.category_id")->where("projcategory_attributes.module",$type)->select("projcategories.id","projcategories.parent_id","projcategories.scope")->where("published",1)->get()->pluck("id",["parent_id","scope"]);

        // dd($this->collect);

    }
    public  function getChildren($category)
    {
        $this->getCategoryRecursiveArray($category);
        return $this->collect;
    }

    public  function getTreeArray($type = "project")
    {
        $this->separator1 = "";
        $this->separator2 = "";
        foreach ($this->getParents($type) as $category) {

            $this->getCategoryRecursiveArray($category);
        }
        return $this->collect;
    }
    public  function getAllTreeArray()
    {
        // $this->separator1 = "";
        // $this->separator2 = "";
        foreach ($this->getParents(null) as $category) {

            $this->getCategoryRecursiveArray($category);
        }
        return $this->collect;
    }
    public  function getParentsArray()
    {
        // $this->separator1 = "";
        // $this->separator2 = "";

        foreach ($this->getParents(null) as $category) {

            $html = "";

            $html  .= $category->DataWithLang()->title;
            $this->collect[] = ["title" => $html, "text" => $html, "id" => $category->id, "imageUrl" => asset("uploads/category/cat.png")];

        }
        return $this->collect;
    }
}
