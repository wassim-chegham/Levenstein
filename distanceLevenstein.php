<?php
/**
 * Class Distance Levenstein
 */
class distanceLevenstein{

	private $_C;
	private $_OP;
	private $_strA;
	private $_strB;
	private $_strA_len;
	private $_strB_len;

	public function __construct($strA="", $strB="")
	{
		$this->_C = array();
		$this->_OP = array();
		$this->_strA = $strA;
		$this->_strB = $strB;
		$this->_strA_len = strlen($this->_strA)+1;
		$this->_strB_len = strlen($this->_strB)+1;
	}
	
	public function doLevensteinDistance()
	{

		// initialisation
		for( $i=0; $i<=$this->_strA_len; $i++ )
		{
			$this->_C[$i][0] = $i; // 0<=i<=N; C[i, 0] <-- i	
		}
		for( $j=1; $j<=$this->_strB_len; $j++ )
		{
			$this->_C[0][$j] = $j; // 1<=j<=M; C[0, j] <-- j
		}		
		
		// corps
		for( $i=1; $i<=$this->_strA_len; $i++ )
		{
			for( $j=1; $j<=$this->_strB_len; $j++ )
			{
				$x = $this->_C[$i-1][$j]+1;
				$y = $this->_C[$i][$j-1]+1;
				
				$ai = $this->_charAt($this->_strA, $i);
				$bj = $this->_charAt($this->_strB, $j);
				
				
				$l = ( $ai == $bj ) ? 0 : 1;

				$z = $this->_C[$i-1][$j-1]+$l;
				$this->_C[$i][$j] = min( $x, min($y, $z) );
				
				//----
				if( $this->_C[$i][$j] == $x )
				{
					$this->_OP[$i][$j] = "supprimer('".$ai."')";
				}
				else if( $this->_C[$i][$j] == $y )
				{
					$this->_OP[$i][$j] = "ajouter('".$bj."')";
				}
				else {
					
					if( $ai == $bj )
					{
						$this->_OP[$i][$j] = "rien()";
					}
					else {
						$this->_OP[$i][$j] = "echanger('".$ai."' avec '".$bj."')";
					}
				}
				
			}			
		}
	}	
	
	public function getMatriceC()
	{
		foreach( $this->_C as $k=>$v )
		{
			echo implode(' ', $v)."\n";
		}
	}
	
	public function getNbMinOperations()
	{
		return $this->_C[$this->_strA_len][$this->_strB_len];
	}
	
	public function getMatriceOP()
	{

		$i=$this->_strA_len;
		$j=$this->_strB_len;
		$seq="";
			
		while( $i != 0 and $j != 0 )
		{
			
			if( preg_match('/^supprimer/', $this->_OP[$i][$j]) != 0 )
			{
				$seq = $this->_OP[$i][$j] . ', ' . $seq;
				$i--;
			}
			else if( preg_match('/^ajouter/', $this->_OP[$i][$j]) != 0 ) {
				$seq = $this->_OP[$i][$j] . ', ' . $seq;
				$j--;
			}
			else if( preg_match('/^echanger/', $this->_OP[$i][$j]) != 0 )
			{
				$seq = $this->_OP[$i][$j] . ', ' . $seq;
				$i--;
				$j--;
			}
			else if( preg_match('/^rien/', $this->_OP[$i][$j]) != 0 ){
				$i--;
				$j--;				
			}
		}
		
		return $seq;
	}	
		
	private function _charAt($string, $index)
	{
		return substr($string, $index-1, 1);
	}
	
	
}

	
	//---

	$chaineA = ( isset($_GET['chaineA']) )?$_GET['chaineA']:'';
	$chaineB = ( isset($_GET['chaineB']) )?$_GET['chaineB']:'';
	$dl = new distanceLevenstein($chaineA, $chaineB);
	
	echo "<form action='' method='get' >";
	echo "<h2>chaine A: <input name='chaineA' value='".$chaineA."' /></h2>";
	echo "<h2>chaine B: <input name='chaineB' value='".$chaineB."' /></h2>";
	echo "<input type='submit' value='calculer la distance d edition' />";
	echo "</form>";
	$dl->doLevensteinDistance($chaineA, $chaineB);
	
	echo "<h3>Matrice C:</h3>";
	echo "<pre>";
	echo $dl->getMatriceC();
	echo "</pre>";
	
	echo sprintf("<h3>Nombre minimal d'operations pour passer de '%s' a '%s': %s</h3>", $chaineA, $chaineB, $dl->getNbMinOperations());
	
	echo "<h3>Operations a effectuer:</h3>";
	echo "<pre>";
	echo $dl->getMatriceOP();
	echo "</pre>";
	
	
?>
