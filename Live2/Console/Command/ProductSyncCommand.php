<?php

namespace Live2\Live2\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\Bootstrap;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class ProductSyncCommand extends Command
{
    protected $productCollectionFactory;

    public function __construct(CollectionFactory $productCollectionFactory)
    {
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('live2:productSync')
            ->setDescription('Synchronize product data and save as JSON.');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->load();

        $productData = [];

        foreach ($productCollection as $product) {
            $productId = $product->getId();
            $productName = $product->getName();
            $productSku = $product->getSku();
            $productPrice = $product->getPrice();

            $productData[] = [
                $product->getData()
            ];
        }

        // Save product data as JSON
        $jsonFile = 'var/product_data.json';
        file_put_contents($jsonFile, json_encode($productData, JSON_PRETTY_PRINT));

        $output->writeln("Product data saved to $jsonFile");
    }
}

