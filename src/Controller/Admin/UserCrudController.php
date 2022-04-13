<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Nos formateurs')
            ->setDefaultSort(['isEnabled' => 'DESC']);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, \EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection $filters): \Doctrine\ORM\QueryBuilder
    {
        $qb = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->where("entity.roles LIKE '%ROLE_TEACHER%%'");
        return $qb;
    }

    public function configureFields(string $pageName): iterable
    {
        yield EmailField::new('email', 'Adresse email');
        yield TextField::new('firstname', 'Prénom');
        yield TextField::new('lastname', 'Nom');
        yield TextField::new('description','Description');
        yield ImageField::new('imageName', 'Photo de profil')
            ->setBasePath($this->getParameter('profilepics'))
            ->onlyOnIndex();
        yield TextField::new('imageFile')->setFormType(VichImageType::class)
             ->setFormTypeOption('allow_delete', false)
             ->onlyOnForms();
        yield BooleanField::new('isEnabled', 'Statut validé.e');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(BooleanFilter::new('isEnabled', 'Statut validé.e'));
    }
}
