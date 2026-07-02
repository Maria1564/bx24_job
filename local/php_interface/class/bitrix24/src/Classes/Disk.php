<?php
/**
 * Документация: https://dev.1c-bitrix.ru/rest_help/disk/index.php
 */
namespace Zloykolobok\Bitrix24\Classes;

use Zloykolobok\Bitrix24\Bitrix;

class Disk extends Bitrix
{
    public function uploadFile(int $id, array $fields, string $content)
    {
        $action = 'disk.storage.uploadfile.json';
        $data['id'] = $id;
        $data['fields'] = $fields;
        $data['fileContent'] = $content;

        dd($data);

        $res = $this->send($data,$action);

        return $res;
    }

    public function getStorage()
    {
        $action = 'disk.storage.getlist.json';
        $data = [];

        $res = $this->send($data,$action);

        return $res;
    }
	 public function getFile($fileId)
    {
        $action = 'disk.file.get.json';
        $data = ['id'=>$fileId];

        $res = $this->send($data,$action);

        return $res;
    }
}