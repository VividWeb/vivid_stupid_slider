<?php
namespace Concrete\Package\VividStupidSlider\Block\VividStupidSlider;
use \Concrete\Core\Block\BlockController;
use Loader;
use File;

class Controller extends BlockController
{
    protected $btTable = 'btVividStupidSlider';
    protected $btInterfaceWidth = "650";
    protected $btWrapperClass = 'ccm-ui';
    protected $btInterfaceHeight = "465";

    public function getBlockTypeDescription()
    {
        return t("Add Stupid Slider to your Site");
    }

    public function getBlockTypeName()
    {
        return t("Stupid Slider");
    }
    public function add()
    {
        $this->requireAsset('core/file-manager');
    }
    public function edit()
    {
        $this->requireAsset('core/file-manager');            
        $db = Loader::db();
        $items = $db->GetAll('SELECT * from btVividStupidSlide WHERE bID = ? ORDER BY sort', array($this->bID));
        $this->set('items', $items);
    }

    public function view()
    {
        $db = Loader::db();
        $items = $db->GetAll('SELECT * from btVividStupidSlide WHERE bID = ? ORDER BY sort', array($this->bID));
        $this->set('items', $items);
    }

    public function duplicate($newBID) {
        parent::duplicate($newBID);
        $db = Loader::db();
        $v = array($this->bID);
        $q = 'select * from btVividStupidSlide where bID = ?';
        $r = $db->query($q, $v);
        while ($row = $r->FetchRow()) {
            $vals = array($newBID,$args['title'][$i],$args['fID'][$i],$args['sort'][$i]);  
            $db->execute('INSERT INTO btVividStupidSlide (bID, title, fID, sort) values(?,?,?,?)', $vals);
        }
    }

    public function delete()
    {
        $db = Loader::db();
        $db->delete('btVividStupidSlide', array('bID' => $this->bID));
        parent::delete();
    }

    public function save($args)
    {
        $db = Loader::db();
        $db->execute('DELETE from btVividStupidSlide WHERE bID = ?', array($this->bID));
        $count = count($args['sort']);
        $i = 0;
        parent::save($args);
        while ($i < $count) {
            $vals = array($this->bID,$args['title'][$i],$args['fID'][$i],$args['sort'][$i]);     
            $db->execute('INSERT INTO btVividStupidSlide (bID, title, fID, sort) values(?,?,?,?)', $vals);
            $i++;
        }
    }
    

}