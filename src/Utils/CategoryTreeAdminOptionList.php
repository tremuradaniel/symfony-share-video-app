<?php
    namespace App\Utils;

    use App\Utils\AbstractClasses\CategoryTreeAbstract;

    class CategoryTreeAdminOptionList extends CategoryTreeAbstract
    {
        public function getCategoryList(array $categories_array, $reapeat = 0)
        {
            foreach ($categories_array as $value)
            {
                $this->categoryList[] = [
                    'name' => str_repeat("-", $reapeat) . $value['name'],
                    'id' => $value['id']
                ];
                if (!empty($value['children']))
                {
                    $reapeat = $reapeat + 2;
                    $this->getCategoryList($value['children'], $reapeat);
                    $reapeat = $reapeat - 2;
                }
            }
            return $this->categoryList;
        }
    }