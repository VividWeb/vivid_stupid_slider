<?php      

namespace Concrete\Package\VividStupidSlider;
use Package;
use BlockType;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package
{

    protected $pkgHandle = 'vivid_stupid_slider';
    protected $appVersionRequired = '5.7.1';
    protected $pkgVersion = '0.9.1';
    
    
    
    public function getPackageDescription()
    {
        return t("Add Stupid Slider to your Site");
    }

    public function getPackageName()
    {
        return t("Stupid Slider");
    }
    
    public function install()
    {
        $pkg = parent::install();
        BlockType::installBlockTypeFromPackage('vivid_stupid_slider', $pkg); 
        
    }
}
?>