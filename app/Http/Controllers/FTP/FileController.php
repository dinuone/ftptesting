<?php

namespace App\Http\Controllers\FTP;

use App\Http\Controllers\Controller;
use App\Models\FileData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use phpseclib3\Net\SFTP;
use Illuminate\Support\Facades\Storage;
use App\Models\FtpFiles;
use App\Imports\FileImport;


class FileController extends Controller
{
       public function getFiles(Request $request)
       {
           $ftp = new SFTP('pm74.paymediasolutions.com');

           if (!$ftp->login('dinuwan', 'Dinuwan@123')) { // Replace with your FTP credentials

               $data = [
                   'success'=>true,
                   'message'=>'FTP credentials are not matching'
               ];
           }

           $remoteFilePath = '/var/www/html/php74/test/';
           $localStoragePath = 'app/public/excels/';
//           $localFileName = '2023-10-13_122344.xlsx';

           //$excelFile = $ftp->get($remoteFilePath.'2023-10-13_122344.xlsx');
           //make directory if directory not already created
           if (!is_dir(storage_path($localStoragePath))) {
               mkdir(storage_path($localStoragePath), 0755, true);
           }

           //get file names
           $fileList = $ftp->nlist($remoteFilePath);
           $xlFileList = [];
           foreach ($fileList as $file) {
               $extension = pathinfo($file, PATHINFO_EXTENSION);
               $filename = pathinfo($file, PATHINFO_FILENAME);
               if($extension == 'CSV'){
                   array_push($xlFileList,$filename.'.'.$extension);
               }

           }

          foreach ($xlFileList as $fileName){
              $ftp->get($remoteFilePath . '/' . $fileName, storage_path($localStoragePath . '/' . $fileName));
              $ftpFile = new FtpFiles();
              $ftpFile->filename = $fileName;
              $ftpFile->path = $localStoragePath.$fileName;
              $ftpFile->save();
          }


           $data = [
               'success' => true,
               'message' => 'success',
           ];

           return response()->json($data);

       }


       public function getAllFiles()
       {
           $allFiles = FtpFiles::all();
           $data = [
               'success'=>true,
               'data'=>$allFiles
           ];

           return response()->json($data);
       }

       public function showExcelFile(Request $request)
       {
           $file_id = $request->id;

           $fileData = FtpFiles::where('id',$file_id)->first();
           $filePath = storage_path($fileData->path);

           $checkExist = FileData::where('file_id',$file_id)->first();
           if(!$checkExist){
               Excel::import(new FileImport($file_id),  $filePath);
           }

           $excelData = FileData::where('file_id',$file_id)->get();

           $data = [
               'success'=>true,
               'data'=>$excelData
           ];

           return response()->json($data);

       }
}
