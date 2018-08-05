<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Bridge\Twig\TwigEngine;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class AppCreateClassCommand extends Command
{
    protected static $defaultName = 'app:create_class';

    protected function configure()
    {
        $this
            ->setDescription('Generates a file in the temp folder')
            ->addArgument('file_name', InputArgument::REQUIRED, 'The name of the file to be generated')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $fileName = $input->getArgument('file_name');

        if ($fileName) {
            $io->note(sprintf('Generating file: %s', $fileName));
        }

        $encoder = new XmlEncoder();

        $io->note(var_dump($encoder->decode(file_get_contents('src/test/test.xml'), 'xml')));


                // $serializer = new Serializer(
                //     array(new PersonsDenormalizer()),
                //     array(new XMLEncoder())
                // );
                // $persons = $serializer->deserialize($data, Persons::class, 'xml');

        $fs = new Filesystem();
        $loader = new FilesystemLoader('src/views');
        $templating = new TwigEngine(new Environment($loader, []), new TemplateNameParser());

        $fs->dumpFile(
            'temp/' . $fileName,
            $templating->render(
                'class.twig',
                [
                    'className'       => 'person',
                    'attributesArray' => [
                        'id', 'name', 'age', 'createdAt', 'sport_person'
                    ]
                ]
            )
        );

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
