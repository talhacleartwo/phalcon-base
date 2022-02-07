<?php
namespace Plugins;

/**
 *
 * @author Asif
 *
 */
trait UtilHelper
{
	public static function uuidv4($data = null)
	{
		$data = $data ?? random_bytes(16);

		$data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}
	
	
	public static function dateTimeNow()
	{
		$t = new \DateTime();
		return $t->format('Y-m-d H:i:s');
	}
	
	
	public static function dateTimeNumeric($date = null)
	{
		if ($date == null)
        {
             $t = new \DateTime();
             return $t->format('d/m/Y H:i');
        }
		else
		{
			if (strtotime($date) === false)
            {
                return 'Invalid Date';
            }
            else
            {
                $t = new \DateTime($date);
                return $t->format('d/m/Y H:i');
            }
		}
	}
	
	
	public static function autoNumber($prefix)
	{
		$chars = "";
		$permitted_chars = '0123456789abcdefghjkmnpqrstuvwxyz';
		return $prefix . '-' . strtoupper(substr(str_shuffle($permitted_chars), 0, 7));
	}
	
	
    /**
     * Function to Display the date on the website
     * If no date given then displays today's date
     * @param \DateTime $date
     * @return boolean
     */
    public static function Displaydate($date = null)
    {
         if ($date == null)
        {
             $t = new \DateTime();
             return $t->format('jS M Y');
        }
        else
        {
            if (strtotime($date) === false)
            {
                $this->flash->error('Invalid Date Given');
            }
            else
            {
                $t = new \DateTime($date);
                return $t->format('jS M Y');
            }
        }
    }

    
    public static function uniqidReal($lenght = 13) {
    	// uniqid gives 13 chars, but you could adjust it to your needs.
    	if (function_exists("random_bytes")) {
    		$bytes = random_bytes(ceil($lenght / 2));
    	} elseif (function_exists("openssl_random_pseudo_bytes")) {
    		$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    	} else {
    		throw new Exception("no cryptographically secure random function available");
    	}
    	return substr(bin2hex($bytes), 0, $lenght);
    }

    public static function Displaydate1($date = null)
    {
        if ($date == null)
        {
            $t = new \DateTime();
            return $t->format('d/m/Y');
        }
        else
        {
            if (strtotime($date) === false)
            {
                $this->flash->error('Invalid Date Given');
            }
            else
            {
                $t = new \DateTime($date);
                return $t->format('d/m/Y');
            }
        }
    }

    /**
     * Function to Display Date and Time from a date given on web page
     * If no date given then displays today's date and time
     * @param date Date
     */
    public static function DisplayDateTime($date = null)
    {
        if ($date == null)
        {
            $t = new \DateTime();
            return $t->format('jS F Y H:i:s');
        }
        else
        {
            if (strtotime($date) === false)
            {

                $this->flash->error('Invalid Date Given');
            }
            else
            {
                $t = new \DateTime($date);
                return $t->format('jS F Y H:i:s');
            }
        }
    }

    /**
     * Function to Change the date on the website
     * If no date given then displays today's date
     * @param \DateTime $date
     * @return boolean
     */
    public static function changedate($date)
    {
        if ($date == null)
        {
            return null;
        }
        else
        {
            $t = new \DateTime($date);
            return $t->format('d-m-Y');
        }
    }

    /**
     * Function to Add Given Date or Todays Date to Database
     */
    public static function AddDate($date = null)
    {
        if ($date == null)
        {
            $dt = new \DateTime();
            return $dt->format('Y-m-d');
        }
        else
        {
            if (strtotime($date) === false)
            {
                $this->flash->error('Invalid Date Given');
            }
            else
            {
                $t = new \DateTime($date);
                return $t->format('Y-m-d');
            }
        }
    }

    public static function dateValid($date)
    {
        if (strtotime($date) === false)
        {
            return false;
        }
        else
        {
            $t = new \DateTime($date);
            return $t->format('Y-m-d');
        }
        return false;
    }
	
    /**
     * Function to Add Given Date or Todays Date to Database
     */
    public static function AddDateTime($date = null)
    {
        if ($date == null)
        {
            $dt = new \DateTime();
            return $dt->format('Y-m-d H:i:s');
        }
        else
        {
            if (strtotime($date) === false)
            {
                $this->flash->error('Invalid Date Given');
            }
            else
            {
                $t = new \DateTime($date);
                return $t->format('Y-m-d H:i:s');
            }
        }
    }



    






    /**
     * get day of the week from a given date or todays day
     * @param datetime $date
     */
    public static function GetDayOfWeek($date = Null)
    {
        if ($date == null)
        {
            $dt = new \DateTime();
            return $dt->format('N');
        }
        else
        {
            if (strtotime($date) === false)
            {
                $this->flash->error('Invalid Date Given');
            }
            else
            {
                $t = new \DateTime($date);
                return $t->format('N');
            }
        }
    }


	
	
    public static function csv_to_array($filename='', $delimiter=',')
    {
        ini_set('auto_detect_line_endings',TRUE);
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if (!$header) {
                    $header = $row;
                }
                else {
                    if (count($header) > count($row)) {
                        $difference = count($header) - count($row);
                        for ($i = 1; $i <= $difference; $i++) {
                            $row[count($row) + 1] = $delimiter;
                        }
                    }

                    $data[] = self::array_combine2($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }





    /**
     * Set JSON response for AJAX, API request
     *
     * @param  string  $content
     * @param  integer $statusCode
     * @param  string  $statusMessage
     *
     * @return \Phalcon\Http\Response
     */
    public function jsonResponse($content, $statusCode = 200, $statusMessage = 'OK')
    {
        // Encode content
        $content = json_encode($content);

        // Create a response since it's an ajax
        $response = new \Phalcon\Http\Response();
        $response->setStatusCode($statusCode, $statusMessage);
        $response->setContentType('application/json', 'UTF-8');
        $response->setContent($content);

        return $response;
    }


    public static function mergePDFFiles(Array $filenames, $outFile)
    {
        $mpdf = new \mPDF();
        if ($filenames) {
            //  print_r($filenames); die;
            $filesTotal = sizeof($filenames);
            $fileNumber = 1;
            $mpdf->SetImportUse();
            if (!file_exists($outFile)) {
                $handle = fopen($outFile, 'w');
                fclose($handle);
            }
            foreach ($filenames as $fileName) {
                if (file_exists($fileName)) {
                    $pagesInFile = $mpdf->SetSourceFile($fileName);
                    //print_r($fileName); die;
                    for ($i = 1; $i <= $pagesInFile; $i++) {
                        $tplId = $mpdf->ImportPage($i);
                        $mpdf->UseTemplate($tplId);
                        if (($fileNumber < $filesTotal) || ($i != $pagesInFile)) {
                            $mpdf->WriteHTML('<pagebreak />');
                        }
                    }
                }
                $fileNumber++;
            }
            $mpdf->Output($outFile, 'D');
        }
    }
    
    
    /**
     * Takes in a filename and an array associative data array and outputs a csv file
     * @param string $fileName
     * @param array $assocDataArray
	 * @param array $headings
     */
    public static function outputCsv($fileName, $data, $headings)
    {
        
        // Open file in append mode
        $file = $fileName . '.csv';
        $delimiter = ',';
        
        $f = fopen('php://memory', 'w');
        
        fputcsv($f, $headings, $delimiter);
        
        foreach($data as $row) {
            fputcsv($f, $row, $delimiter);
        }
        fseek($f, 0);
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $file . '";');
        
        fpassthru($f);
        fclose($f);
        exit();
    }
	
}

