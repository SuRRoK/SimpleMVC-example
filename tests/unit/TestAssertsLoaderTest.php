<?php


class TestAssertsLoaderTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {

    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $assetsPath = __DIR__.'/js_test/';
        if (!file_exists($assetsPath)) {
            mkdir($assetsPath);
        }

        $files = ['file2.js', 'file1.js'];

        foreach ($files as $file) {
            $newFile = fopen($assetsPath . $file, 'wb');
            fwrite($newFile, $file);
            sleep(2);
        }
        $asset = $this->make(ItForFree\SimpleAsset\SimpleAsset::class, [
            'basePath' => $assetsPath,
            'js' => $files[1],
            'copyToAssetsDir' => Codeception\Stub\Expected::once()
        ]);

        $asset->js = [
            $files[1],
        ];

        $asset->needs = [];
//        \ItForFree\rusphp\File\Directory\Directory::clear($assetsPath);

        $asset->publish();
//        vdie($asset);

    }
}