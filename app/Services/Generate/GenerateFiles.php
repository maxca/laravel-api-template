<?php

namespace App\Services\Generate;

use Artisan;
use Illuminate\Support\Str;

/**
 * Class GenerateFiles
 * @package Samark\ModuleGenerate\Services\Generate
 * @author samark chisanguan <samarkchsngn@gmail.com>
 */
class GenerateFiles implements GenerateFilesInterface
{
    use GenerateFileConfig;

    /**
     * set replace string
     * @var string
     */
    protected $replace;

    /**
     * set replace small case
     * @var string
     */
    protected $replaceSmall;

    /**
     * set replace snake case
     * @var string
     */
    protected $replaceSnake;

    /**
     * set replace url
     * @var string
     */
    protected $replaceUrl;

    /**
     * @var replace plural
     */
    protected $replacePlural;

    /**
     * set action
     * @var string
     */
    protected $action;

    /**
     * set config
     * @var array
     */
    protected $config;

    /**
     * set file name
     * @var string
     */
    protected $filename;

    /**
     * set path
     * @var string
     */
    protected $path;

    /**
     * set style
     * @var string
     */
    protected $style;

    /**
     * set data for write file
     * @var string
     */
    protected $data;

    /** @var string
     * set namespace of controller
     */
    protected $controllerNamespace = 'App\Http\Controllers\API\V1';

    /** @var string
     * set default repository namespace
     */
    protected $repositoryNamespace = 'App\Interfaces';

    /** @var bool
     * set default using repository
     */
    protected $useRepository = true;

    /**
     * set config path
     * @var array
     */
    protected $configPath = array();

    /**
     * @var bool
     */
    protected $customPath = true;

    /**
     * @var
     */
    protected $templatePath;

    /**
     * @var array
     */
    protected $noNeedKey = array(
        'Model' => true,
    );

    /**
     * @var array
     */
    protected $needDuplicate = array();

    /**
     * @var array
     */
    protected $requestType = array(
        'Index'  => true,
        'Store'  => true,
        'Detail' => true,
        'Update' => true,
        'Delete' => true,
        'Export' => true,
    );

    /**
     * @var array
     */
    protected $configLang = array(
        'en' => false,
        'th' => false,
    );

    /**
     * GenerateFiles constructor.
     * @param string $namespace
     */
    public function __construct($namespace = '')
    {
        $this->setReplaceConfig($namespace);
        $this->configPath    = $this->getConfig();
        $this->customPath    = $this->getCustomPath();
        $this->needDuplicate = $this->getNeedDuplicate();
    }

    /**
     * @param $replace
     */
    protected function setReplaceConfig($replace)
    {
        $this->replace       = cvCamel($replace);
        $this->replaceSmall  = strtolower($replace);
        $this->replaceSnake  = self::strCamelCase($replace);
        $this->replaceUrl    = $this->urlGenerate($this->replaceSnake);
        $this->replacePlural = strtolower(Str::plural($this->replaceSnake));
    }

    /**
     * @param array $config
     */
    public function setConfig($config = array())
    {
        $this->config = $config;
    }

    /**
     * @param string $path
     */
    public function setPath($path = '')
    {
        $this->path = $path;
    }

    /**
     * @param $path
     */
    public function setTemplatePath($path)
    {
        $this->templatePath = $path;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename = '')
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getFullFileName()
    {
        return $this->path . '/' . $this->filename;
    }

    /**
     * @param $data
     * @return bool|int
     */
    public function writeFile($data)
    {
        if (!is_dir($this->path)) {
            mkdir($this->path, 0777, true);
        }
        $filename = $this->getFullFileName();
        return file_put_contents($filename, $data . "\r\n", FILE_APPEND);
    }

    /**
     * @param string $input
     * @return string
     */
    protected function strCamelCase($input = '')
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    /**
     * execute process
     */
    public function execute()
    {
        foreach ($this->configPath as $key => $list) {
            # reset action
            $this->action = '';
            if (array_key_exists($key, $this->needDuplicate)) {
                $property = $this->needDuplicate[$key];
                $this->processDuplicate($key, $property, $list);
            } else {
                $filename = $this->checkFilename(
                    $key, $list['name'] ? $list['name'] : false,
                    $list['isView'] ? $list['isView'] : false
                );
                $this->processReadWriteFile($filename, $list);
            }
        }
    }

    /**
     * @param $key
     * @param $name
     * @param bool $isView
     * @return string
     */
    protected function checkFilename($key, $name, $isView = false)
    {
        if ($isView) {
            return $name . '.php';
        }
        if (array_key_exists($key, $this->noNeedKey)) {
            return $this->replace . '.php';
        }
        $key = $name ? $name : $key;
        return $this->replace . ucfirst($key) . '.php';
    }

    /**
     * @param $key
     * @param $property
     * @param $list
     * @throws \Exception
     */
    protected function processDuplicate($key, $property, $list)
    {
        if ($key === 'Lang') {
            foreach ($this->configLang as $key => $value) {
                $path    = $list['target'] . '/' . $key;
                $newFile = $this->readAndReplaceFile($list['resource']);

                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                $fullPath = $path . '/' . strtolower($this->replace) . '.php';
                file_put_contents($fullPath, $newFile);
                $this->printLine($fullPath);
            }

        } else {
            foreach ($this->{$property} as $action => $need) {
                if ($need === true) {
                    $this->action = ucfirst($action);
                    $filename     = ucfirst($action) . $this->replace . ucfirst($key) . '.php';
                    $this->processReadWriteFile($filename, $list);
                }
            }
        }

    }

    /**
     * @param $filename
     * @param $list
     * @throws \Exception
     */
    protected function processReadWriteFile($filename, $list)
    {
        $newFile = $this->readAndReplaceFile($list['resource']);
        if (isset($list['namespace'])) {
            $this->controllerNamespace = $list['namespace'];
        } else {
            $this->controllerNamespace = $this->controllerNamespace . '\\' . $this->replace;
        }
        if ($this->useRepository === true) {
            $this->repositoryNamespace = $this->repositoryNamespace . '\\' . $this->replace . 'Repository';
        } else {
            $this->repositoryNamespace = 'App\Repositories\\' . $this->replace . '\\' . $this->replace . 'RepositoryEloquent as ' . $this->replace . 'Repository';

        }
        if ($list['needDir'] === true) {
            $path = $this->path . '/' . $list['target'] . '/' . $this->replace;
        } else {
            $path = $this->path . '/' . $list['target'] . '/';
        }
        $this->wirteFileAndMakePath($path, $filename, $newFile);
        $this->printLine($filename);
    }

    /**
     * @param $path
     * @param $filename
     * @param $newFile
     */
    protected function wirteFileAndMakePath($path, $filename, $newFile)
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $fullPath = $path . '/' . $filename;
        file_put_contents($fullPath, $newFile);
    }

    /**
     * @param string $text
     */
    protected function printLine($text = '')
    {
        echo "\r\n";
        echo "Write file \e[44m" . $text . " success \e[49m";
    }

    /**
     * @param $config
     * @return mixed|string
     * @throws \Exception
     */
    protected function readAndReplaceFile($config)
    {
        if (!empty($this->templatePath)) {
            $fileLocation = base_path() . '/' . $this->templatePath . $config;
            if (file_exists($fileLocation)) {
                $file = file_get_contents($fileLocation);
                return $this->replaceFile($file);
            }

        } elseif (file_exists((__DIR__ . '/' . $config))) {
            $fileLocation = __DIR__ . '/' . $config;
            $file         = file_get_contents($fileLocation);
            return $this->replaceFile($file);
        }

        throw new \Exception("Can't read file :" . $fileLocation);


    }

    /**
     * @param string $input
     * @return mixed
     */
    protected function urlGenerate($input = '')
    {
        return str_replace("_", '-', $input);
    }


    /**
     * @param string $file
     * @return mixed|string
     */
    protected function replaceFile($file = '')
    {
        $file = str_replace(array("{replace}"), $this->replace, $file);
        $file = str_replace(array("{replace_plural}"), $this->replacePlural, $file);
        $file = str_replace(array("{replace_sm}"), $this->replaceSmall, $file);
        $file = str_replace(array("{replace_snc}"), $this->replaceSnake, $file);
        $file = str_replace(array("{replace_url}"), $this->replaceUrl, $file);
        $file = str_replace(array("{action}"), $this->action, $file);
        $file = str_replace(array("{action_sm}"), strtolower($this->action), $file);
        $file = str_replace(array("{controller_namespace}"), $this->controllerNamespace, $file);
        $file = str_replace(array("{repository}"), $this->repositoryNamespace, $file);
        return $file;
    }

    /**
     * @return void
     */
    public function makeMigration()
    {
        $tableName = strtolower(Str::plural($this->replace));
        $call      = 'create_table_' . $tableName;
        $this->printLine('run migration file');
        $exitCode = Artisan::call('make:migration', array(
            'name'     => $call,
            '--create' => $tableName,
        ));
        $this->printline('ok');
    }

    /**
     * @param string $path
     */
    public function appendRoute($path = 'api')
    {
        if (file_exists(base_path("routes/{$path}.php"))) {
            $data = "\r\n";
            $data .= "# {$this->replace} \r\n";
            $data .= "require base_path('routes/{$this->replace}/{$this->replace}Route.php');";
            file_put_contents(base_path("routes/{$path}.php"), $data . "\r\n", FILE_APPEND);
        }
    }
}
