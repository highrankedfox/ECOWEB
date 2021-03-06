<?php

namespace App\Controller\Admin;

use App\Entity\Lesson;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use SebastianBergmann\CodeCoverage\Report\Text;

class LessonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lesson::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Vos leçons');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, \EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection $filters): \Doctrine\ORM\QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->where('entity.User = ' . $this->getUser());
        return $qb;
    }

    public function createEntity(string $entityFqcn)
    {
        $lesson = new Lesson();
        $lesson->setUser($this->getUser());

        return $lesson;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre de la leçon'),
            AssociationField::new('Section')->setCrudController(SectionCrudController::class)->setQueryBuilder(
                fn (QueryBuilder $queryBuilder) => $queryBuilder
                    ->andWhere('entity.User = ' . $this->getUser())
            ),
            UrlField::new('video', 'Vidéo de la leçon'),
            TextEditorField::new('content', 'Contenu'),
        ];
    }
}
