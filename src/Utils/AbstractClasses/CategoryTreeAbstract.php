<?php
    namespace App\Utils\AbstractClasses;

    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

    abstract class CategoryTreeAbstract {

        public $categoriesArrayFromDB;
        protected static $dbconnection;

        public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
        {
            $this->entityManager = $entityManager;
            $this->urlGenerator = $urlGenerator;
            $this->categoriesArrayFromDB = $this->getCategories();
        }

        abstract public function getCategoryList(array $categories_array);

        public function buildTree(int $parent_id = null): array
        {
            $subcategory = [];
            foreach ($this->categoriesArrayFromDB as $category) {
                $hasChild = $category['parent_id'] == $parent_id;
                if($hasChild)
                {
                    $children = $this->buildTree($category['id']);
                    if($children) $category['children'] = $children;
                    // adds $category to $subcategory array
                    $subcategory[] = $category;
                }
            }
            return $subcategory;
        }

        private function getCategories(): array
        {
            if(self::$dbconnection)
            {
                return self::$dbconnection;
            } else {
                $conn = $this->entityManager->getConnection();
                $sql = "SELECT * FROM categories";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                // Singleton pattern to query the db only once
                return self::$dbconnection = $stmt->fetchAll();
            }
        }
    }
