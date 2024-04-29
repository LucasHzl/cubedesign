<?php

namespace App\Controller\Admin;

use App\Entity\Orders;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrdersCrudController extends AbstractCrudController implements EventSubscriberInterface
{
    public static function getEntityFqcn(): string
    {
        return Orders::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('order_number'),
        ];
    }

    public static function getSubscribedEvents() {
        return [
            BeforeEntityPersistedEvent::class => ["beforePersistEntity"]
        ];
    }

    public function beforePersistEntity(BeforeEntityPersistedEvent $event) {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Orders) {
            $entity->setDate(new \DateTime());
        }
    }

}
