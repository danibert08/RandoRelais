<?php

namespace App\Command;

use App\Repository\ServiceRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Slugger\SluggerInterface;

class ServiceSluggerCommand extends Command
{
    protected static $defaultName = 'service:slugger';
    protected static $defaultDescription = 'Create a slug for one or many services.';

    // Proprietes needed in the object.
    private $serviceRepository;
    private $entityManagerInterface;
    private $sluggerInterface;
    
    // We make our properties available in each method of the class.
    public function __construct(ServiceRepository $serviceRepository, EntityManagerInterface $entityManagerInterface, SluggerInterface $sluggerInterface)
    {
        $this->serviceRepository = $serviceRepository;
        $this->entityManagerInterface = $entityManagerInterface;
        $this->sluggerInterface = $sluggerInterface;

        // In order to use the a command with a constructor we need to 	initialize the parent constructor.
        parent:: __construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('serviceId', InputArgument::OPTIONAL, 'The id of the service')
            ->addOption('updatedAt', null, InputOption::VALUE_NONE, 'The date the service was updated')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // e.g php bin/console service:slugger 2
        $serviceId = $input->getArgument('serviceId');

        // e.g php bin/console service:slugger --updatedAt
        // $optionUpdatedAt == true if is specified in the commandand and == false if not.
        $optionUpdatedAt = $input->getOption('updatedAt');

        // We get one or more services that we want to update.
        if ($serviceId) {
            // We only update the service whose the ID is equeal to $serviceId.
            $service = $this->serviceRepository->find($serviceId);
            $this->saveService($service, $optionUpdatedAt);
        } else {
            // We get all the servicies.
            $services = $this->serviceRepository->findAll();
            // We upadate all the servicies.
            foreach ($services as $service) {
                $this->saveService($service, $optionUpdatedAt);
            }
        }

        // We flush the data with the flush() method of the EntityManagerInterface.
        $this->entityManagerInterface->flush();

        // We display a success message.
        $io->success("Mise à jour de la base de données effectuée");

        return Command::SUCCESS;
    }

    /**
     * Method who backup in the database a service with is slug.
     *
     * @param [type] $service
     * @param [type] $optionUpdatedAt
     * @return void
     */
    private function saveService($service, $optionUpdatedAt)
    {
        // For each service we get the name.
        $name = $service->getName();

        // We generate the slug with the slug() of the SluggerInterface.
        $slug = $this->sluggerInterface->slug($name);

        // We upadate the slug property.
        // The PHP function strtolower() return a string with all alphabetic characters converted to lowercase.
        $service->setSlug(strtolower($slug));

        if ($optionUpdatedAt) {
            // If we specify the updatedAt option we also update the property updatedAt in the database.
            $service->setUpdatedAt(new DateTime());
        }
    }
}
