<?php
/**
 * 360Contest
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    360Contest
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
App::uses('File', 'Utility');
APP::uses('Folder', 'Utility');
class ExtensionsLocalesController extends ExtensionsAppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'ExtensionsLocales';
    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Setting',
        'User'
    );
    public function admin_index()
    {
        $this->set('title_for_layout', __l('Locales'));
        $folder = &new Folder;
        $folder->path = APP . 'Locale';
        $content = $folder->read();
        $locales = $content['0'];
        foreach($locales as $i => $locale) {
            if (strstr($locale, '.') !== false) {
                unset($locales[$i]);
            }
        }
        $this->set(compact('content', 'locales'));
    }
    public function admin_activate($locale = null)
    {
        if ($locale == null || !is_dir(APP . 'Locale' . DS . $locale)) {
            $this->Session->setFlash(__l('Locale does not exist.') , 'default', array(
                'class' => 'error'
            ));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $result = $this->Setting->write('Site.locale', $locale);
        if ($result) {
            $this->Session->setFlash(sprintf(__l("Locale '%s' set as default") , $locale) , 'default', array(
                'class' => 'success'
            ));
        } else {
            $this->Session->setFlash(__l('Could not save Locale setting.') , 'default', array(
                'class' => 'error'
            ));
        }
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    public function admin_add()
    {
        $this->set('title_for_layout', __l('Upload a new locale'));
        if ($this->request->is('post') && !empty($this->request->data)) {
            $file = $this->request->data['Locale']['file'];
            unset($this->request->data['Locale']['file']);
            // get locale name
            $zip = zip_open($file['tmp_name']);
            $locale = null;
            if ($zip) {
                while ($zipEntry = zip_read($zip)) {
                    $zipEntryName = zip_entry_name($zipEntry);
                    if (strstr($zipEntryName, 'LC_MESSAGES')) {
                        $zipEntryNameE = explode('/LC_MESSAGES', $zipEntryName);
                        if (isset($zipEntryNameE['0'])) {
                            $pathE = explode('/', $zipEntryNameE['0']);
                            if (isset($pathE[count($pathE) -1])) {
                                $locale = $pathE[count($pathE) -1];
                            }
                        }
                    }
                }
            }
            zip_close($zip);
            if (!$locale) {
                $this->Session->setFlash(__l('Invalid locale.') , 'default', array(
                    'class' => 'error'
                ));
                $this->redirect(array(
                    'action' => 'add'
                ));
            }
            if (is_dir(APP . 'Locale' . DS . $locale)) {
                $this->Session->setFlash(__l('Locale already exists.') , 'default', array(
                    'class' => 'error'
                ));
                $this->redirect(array(
                    'action' => 'add'
                ));
            }
            // extract
            $zip = zip_open($file['tmp_name']);
            if ($zip) {
                while ($zipEntry = zip_read($zip)) {
                    $zipEntryName = zip_entry_name($zipEntry);
                    if (strstr($zipEntryName, $locale . '/')) {
                        $zipEntryNameE = explode($locale . '/', $zipEntryName);
                        if (isset($zipEntryNameE['1'])) {
                            $path = APP . 'Locale' . DS . $locale . DS . str_replace('/', DS, $zipEntryNameE['1']);
                        } else {
                            $path = APP . 'Locale' . DS . $locale . DS;
                        }
                        if (substr($path, strlen($path) -1) == DS) {
                            // create directory
                            mkdir($path);
                        } else {
                            // create file
                            if (zip_entry_open($zip, $zipEntry, 'r')) {
                                $fileContent = zip_entry_read($zipEntry, zip_entry_filesize($zipEntry));
                                touch($path);
                                $fh = fopen($path, 'w');
                                fwrite($fh, $fileContent);
                                fclose($fh);
                                zip_entry_close($zipEntry);
                            }
                        }
                    }
                }
            }
            zip_close($zip);
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
    public function admin_edit($locale = null)
    {
        $this->set('title_for_layout', sprintf(__l('Edit locale: %s') , $locale));
        if (is_null($locale)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!file_exists(APP . 'Locale' . DS . $locale . DS . 'LC_MESSAGES' . DS . 'default.po')) {
            $this->Session->setFlash(__l('The file default.po does not exist.') , 'default', array(
                'class' => 'error'
            ));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $file = &new File(APP . 'Locale' . DS . $locale . DS . 'LC_MESSAGES' . DS . 'default.po', true);
        $content = $file->read();
        if (!empty($this->request->data)) {
            // save
            if ($file->write($this->request->data['Locale']['content'])) {
                $this->Session->setFlash(__l('Locale updated successfully') , 'default', array(
                    'class' => 'success'
                ));
                $this->redirect(array(
                    'action' => 'index'
                ));
            }
        }
        $this->set(compact('locale', 'content'));
    }
    public function admin_delete($locale = null)
    {
        if (is_null($locale)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $folder = &new Folder;
        if ($folder->delete(APP . 'Locale' . DS . $locale)) {
            $this->Session->setFlash(__l('Locale deleted successfully.') , 'default', array(
                'class' => 'success'
            ));
        } else {
            $this->Session->setFlash(__l('Local could not be deleted.') , 'default', array(
                'class' => 'error'
            ));
        }
        $this->redirect(array(
            'action' => 'index'
        ));
    }
}
