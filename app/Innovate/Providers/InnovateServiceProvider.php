<?php

namespace Innovate\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class InnovateServiceProvider.
 */
class InnovateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /*
         * check if The user Enabled Redis cache
         */
        if (env('LADA_CACHE_DRIVER')) {
            $this->app->register('\Spiritix\LadaCache\LadaCacheServiceProvider');
        }

        $this->registerBinding();
    }

    /**
     *  Bind all innovate module repository to there implementation
     *  which do not have there own service provider.
     */
    private function registerBinding()
    {
        /*
         * bind Tax Repository to its Eloquent implementation
         */
        $this->app->bind(
            \Innovate\Repositories\Tax\TaxContract::class,
            \Innovate\Repositories\Tax\EloquentTaxRepository::class
        );
        /*
         * bind BankTransferInfoContract to its elquent implementation EloquentBankTransferInfoRepository
         */
        $this->app->bind(
            \Innovate\Repositories\StaticPages\BankTransferInfo\BankTransferInfoContract::class,
            \Innovate\Repositories\StaticPages\BankTransferInfo\EloquentBankTransferInfoRepository::class
        );

        /*
         *
         */
        $this->app->bind(
            \Innovate\Repositories\StaticPages\CheckOutAgreement\CheckOutAgreementContract::class,
            \Innovate\Repositories\StaticPages\CheckOutAgreement\EloquentCheckOutAgreementRepository::class
        );

        $this->eavAttributeBindings();
        $this->eavAttributeCategoryBindings();

        $this->CategoryBindings();
        $this->CategoryDescriptionBindings();

        $this->eavIntValueBinding();
        $this->eavTextValueBinding();
        $this->eavVarcharValueBinding();

        $this->ProductDescripionBinding();

        $this->ImageDriverBinding();
    }

    /**
     * Binds the Eav Attribute Contracts with its concrete class.
     */
    private function eavAttributeBindings()
    {
        return $this->app->bind(
            \Innovate\Repositories\Eav\Attribute\EavAttributeContract::class,
            \Innovate\Repositories\Eav\Attribute\EloquentEavAttributeRepository::class
        );
    }

    private function eavAttributeCategoryBindings()
    {
        return $this->app->bind(
            \Innovate\Repositories\Eav\Category\EavCategoryContract::class,
            \Innovate\Repositories\Eav\Category\EloquentEavCategoryRepository::class
        );
    }

    private function CategoryBindings()
    {
        return $this->app->bind(
            \Innovate\Repositories\Category\CategoryContract::class,
            \Innovate\Repositories\Category\EloquentCategoryRepository::class
        );
    }

    private function CategoryDescriptionBindings()
    {
        return $this->app->bind(
            \Innovate\Repositories\Category\CategoryDescriptionContract::class,
            \Innovate\Repositories\Category\EloquentCategoryDescriptionRepository::class
        );
    }

    private function eavIntValueBinding()
    {
        return $this->app->bind(
            \Innovate\Repositories\Eav\Value\EavValueIntContract::class,
            \Innovate\Repositories\Eav\Value\EloquentEavValueIntRepository::class
        );
    }

    private function eavTextValueBinding()
    {
        return $this->app->bind(
            \Innovate\Repositories\Eav\Value\EavValueTextContract::class,
            \Innovate\Repositories\Eav\Value\EloquentEavValueTextRepository::class
        );
    }

    private function eavVarcharValueBinding()
    {
        return $this->app->bind(
            \Innovate\Repositories\Eav\Value\EavValueVarcharContract::class,
            \Innovate\Repositories\Eav\Value\EloquentEavValueVarcharRepository::class
        );
    }

    private function ProductDescripionBinding()
    {
        return $this->app->bind(
            \Innovate\Repositories\Product\ProductDescriptionContract::class,
            \Innovate\Repositories\Product\EloquentProductDescriptionRepository::class
        );
    }

    /**
     * Bind the appropriate image driver to use.
     */
    private function ImageDriverBinding()
    {
        return $this->app->bind(
            \Innovate\Image\InnovateImageUploadContract::class,
            \Innovate\Image\InnovateImageUpload::class
        );
    }
}
