<?php

namespace AppBundle\Model\Catalogues;

/**
 * SetPaths
 */
class SetPaths
{
	    
	/**
     * {@inheritdoc}
     */
    public function setPaths($em, $catalogueId)
    {
        //current directory parrent
        $parentData = 0;
        //name to view
        $currentCatalogueName = '(GŁÓWNY) ..\\';
        //array of catalogue names
        $pathNameShow = [];
        //group id for directory to check privliges
        $groupId = null;        
        $pathData = [];  
        $path = '';
        $x = 0;
        //set main path
        $path =  getcwd().'/documents/';

        //make document directory if not exist yet 
        if (!is_dir($path)) {
            //make new directory
            mkdir($path, 0755, true);            
        }
        
        //get current catalogue data
        $catalogueData = $em
            ->getRepository('AppBundle:Catalogue')
            ->findOneByIdData($catalogueId); 
        
        //get list of catalogue id's and names
        $catalogueNames = $em
            ->getRepository('AppBundle:Catalogue')
            ->getCatalogueList(); 

        //set data depends if catalogue exist (no data == main Catalogue)
        if ($catalogueData != null) {
            //get catalogue data
            $catalogueId = $catalogueData['id'];
            $currentCatalogueName = $catalogueData['name'];
            $parentData = $catalogueData['parent'];
            $groupId = $catalogueData['groupId'];
            $catalogueName = $catalogueData['name'];
            $parent = $catalogueData['parent'];
                    
            //set catalogues data by find all by parent       
            if ($parent != 0 && $parent != null) {
                
                while ($catalogueData != null) {
                   //set catalogue data to array
                    $pathData[$catalogueData['id']] = $catalogueName;
                    //get catalogue data by parent
                    $catalogueData = $em
                        ->getRepository('AppBundle:Catalogue')
                        ->findOneByParentId($parent); 
                    //break if there are no higher catalogues in tree
                    if ($catalogueData == null) {
                        break;
                    }
                    //get catalogueData
                    $parent = $catalogueData['parent'];    
                    $catName = $catalogueData['name'];   

                }
                //reverse array becouse of searching data from last catalogue in tree to root catalogue
                $pathData = array_reverse($pathData, true);
                               
                foreach ($pathData as $key => $value) {
                    //set path
                    $path .= $key.'/';
                    //set array of names to show nawigate bar                    
                    if (array_key_exists($key, $catalogueNames)) {                        
                        $catalogueName = $catalogueNames[$key];                
                        $pathNameShow[$key] = $catalogueName;
                    }
                }

            } else {              
                //get catalogue data
                $catalogueId = $catalogueData['id'];          
                $path .= $catalogueId.'/';                
                if (array_key_exists($catalogueId, $catalogueNames)) {                        
                    $catalogueName = $catalogueNames[$catalogueId];                
                    $pathNameShow[$catalogueId] = $catalogueName;
                }
            }
            
        }

        $data = [];
        $data['directory'] = $path;
        $data['catalogueData'] = $catalogueData;
        $data['parentData'] = $parentData;
        $data['currentCatalogueName'] = $currentCatalogueName;
        $data['pathNameShow'] = $pathNameShow;
        $data['groupId'] = $groupId;

		return $data;
		
	}
		
}
