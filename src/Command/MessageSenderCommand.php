<?php

namespace App\Command;

use App\Entity\Campaign;
use App\Provider\MessageSmsProvider;
use App\Sender\MessageSmsSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MessageSenderCommand extends Command
{
    protected static $defaultName = 'app:send-sms';

    /**
     * @var SymfonyStyle
     */
    private $io;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var MessageSmsProvider
     */
    private $provider;

    /**
     * @var MessageSmsSender
     */
    private $sender;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em, MessageSmsProvider $provider, MessageSmsSender $sender)
    {
        $this->em = $em;
        $this->provider = $provider;
        $this->sender = $sender;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Send SMS campaign.')
            ->addArgument('campaign_id', InputArgument::REQUIRED, 'Db campaign id')
            ->setHelp(<<<EOF
Command <info>%command.name%</info> can send SMS campaign.
Example :

  <info>%command.full_name% campaign_id</info>

EOF
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

        $campaign = $this->getCampaign((int) $input->getArgument('campaign_id'));
        $keyId = $campaign->getId();
        $messages = $this->provider->provide($campaign);
        $this->sender->send($messages, ['keyid' => $keyId]);

        $this->io->section('Total');
        $this->io->listing([
            sprintf('Keyid : <info>%d</info>', $keyId),
            sprintf('Messages : <info>%d</info>', count($messages)),
        ]);

        return 0;
    }

    /**
     * @param int $id
     *
     * @return Campaign
     */
    private function getCampaign(int $id): Campaign
    {
        return $this->em->find(Campaign::class, $id);
    }
}
