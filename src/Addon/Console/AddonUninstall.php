<?php

namespace Anomaly\Streams\Platform\Addon\Console;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Extension\ExtensionManager;
use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class AddonUninstall
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonUninstall extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'addon:uninstall {addon} {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall an addon.';

    /**
     * Execute the console command.
     *
     * @param AddonCollection $addons
     * @param ModuleManager $modules
     * @param ExtensionManager $extensions
     */
    public function handle(ModuleManager $modules, ExtensionManager $extensions)
    {
        $addon = app($this->argument('addon'));

        if ($addon instanceof Module) {

            $modules->uninstall($addon);

            $this->info('The [' . $this->argument('addon') . '] module was uninstalled.');
        }

        if ($addon instanceof Extension) {

            $extensions->uninstall($addon);

            $this->info('The [' . $this->argument('addon') . '] extension was uninstalled.');
        }
    }

    /**
     * Get the command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['addon', InputArgument::OPTIONAL, 'The addon to uninstall.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['seed', null, InputOption::VALUE_NONE, 'Seed the addon after installing?'],
        ];
    }
}
