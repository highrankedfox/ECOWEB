<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FormationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Formation::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Vos formations')
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, \EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection $filters): \Doctrine\ORM\QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->where('entity.User = ' . $this->getUser());
        return $qb;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            yield TextField::new('title'),
            yield ImageField::new('imageName', 'Illustration')
                ->setBasePath($this->getParameter('formationimg'))
                ->onlyOnIndex(),
            yield TextField::new('imageFile')->setFormType(VichImageType::class)
                ->setFormTypeOption('allow_delete', false)
                ->onlyOnForms(),
            yield TextField::new('description'),
        ];
    }
}
