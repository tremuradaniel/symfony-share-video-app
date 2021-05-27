<?php
    namespace App\Utils;

    use App\Twig\AppExtension;
    use App\Utils\AbstractClasses\CategoryTreeAbstract;

    class CategoryTreeFrontPage extends CategoryTreeAbstract {
        public $html1 = '<ul>';
        public $html2 = '<li>';
        public $html3 = '<a href="';
        public $html4 = '">';
        public $html5 = '</a>';
        public $html6 = '</li>';
        public $html7 = '</ul>';

        public function getCategoryList(array $categories_array): string
        {
            $this->categoryList .= $this->html1;
            foreach ($categories_array as $value) {
                $catName = $this->slugger->slugify($value['name']);
                $url = $this->urlGenerator->generate('videoList', [
                    'categoryName' => $catName,
                    'id' => $value['id']
                ]);
                $this->categoryList .= $this->html2 . $this->html3 . $url . $this->html4 . $value['name'] . $this->html5;
                if(!empty($value['children'])) $this->getCategoryList($value['children']);
                $this->categoryList .= $this->html6;
            }
            $this->categoryList .= $this->html7;
            return $this->categoryList;
        }

        public function getMainParent(int $id): array
        {
            $key = array_search($id, array_column($this->categoriesArrayFromDB, 'id'));
            if($this->categoriesArrayFromDB[$key]['parent_id'] != null)
            {
                return $this->getMainParent($this->categoriesArrayFromDB[$key]['parent_id']);
            } else {
                return [
                    'id' =>$this->categoriesArrayFromDB[$key]['id'],
                    'name' =>$this->categoriesArrayFromDB[$key]['name']
                ];
            }
        }

        public function getCategoryListAndParent(int $id): string
        {
            $this->slugger = new AppExtension; // Twig extension to slugify url's for categories
            $parentData = $this->getMainParent($id); // main parent of subcategory
            $this->mainParentName = $parentData['name']; // for accesing in view
            $this->mainParentId = $parentData['id']; // for accesing in view
            $key = array_search($id, array_column($this->categoriesArrayFromDB, 'id'));
            $this->currentCategoryName = $this->categoriesArrayFromDB[$key]['name']; // for accesing in view
            $categories_array = $this->buildTree($parentData['id']); // builds array for generating neste html list
            return $this->getCategoryList($categories_array);
        }
    }
