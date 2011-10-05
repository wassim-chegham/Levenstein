/**
 * Class Distance Levenstein
 */
public class distanceLevenstein{

	private int[][] _C;
	private String [][] _OP;
	private String _strA;
	private String _strB;
	private int _strA_len;
	private int _strB_len;

	public distanceLevenstein(String strA, String strB)
	{
		this._strA = strA;
		this._strB = strB;
		this._strA_len = this._strA.length()+1;
		this._strB_len = this._strB.length()+1;
		this._C = new int[this._strA_len][this._strB_len];
		this._OP = new String[this._strA_len][this._strB_len];
	}
	
	public void doLevensteinDistance()
	{

		// initialisation
		int i, j, x, y, z, l;
		char ai, bj;
		
		for( i=0; i<this._strA_len; i++ )
		{
			this._C[i][0] = i; // 0<=i<=N; C[i, 0] <-- i	
		}
		for( j=1; j<this._strB_len; j++ )
		{
			this._C[0][j] = j; // 1<=j<=M; C[0, j] <-- j
		}		
		
		// corps
		for( i=1; i<this._strA_len; i++ )
		{
			for( j=1; j<this._strB_len; j++ )
			{
				x = this._C[i-1][j]+1;
				y = this._C[i][j-1]+1;
				
				ai = this._strA.charAt(i-1);
				bj = this._strB.charAt(j-1);
				
				l = ( ai == bj ) ? 0 : 1;

				z = this._C[i-1][j-1]+l;
				this._C[i][j] = Math.min( x, Math.min(y, z) );
				
				//----
				if( this._C[i][j] == x )
				{
					this._OP[i][j] = "supprimer('"+ai+"')";
				}
				else if( this._C[i][j] == y )
				{
					this._OP[i][j] = "ajouter('"+bj+"')";
				}
				else {
					
					if( ai == bj )
					{
						this._OP[i][j] = "rien()";
					}
					else {
						this._OP[i][j] = "echanger('"+ai+"' avec '"+bj+"')";
					}
				}
				
			}			
		}
	}	
	
	public String getMatriceC()
	{
		String res = "";
		for( int i=0; i<this._strA_len; i++ )
		{
			for( int j=0; j<this._strB_len; j++ )
			{
				res += this._C[i][j];
			}
			res += "\n";
		}
		return res;
	}
	
	public int getNbMinOperations()
	{
		return this._C[this._strA_len-1][this._strB_len-1];
	}
	
	public String getMatriceOP()
	{

		int i=this._strA_len-1;
		int j=this._strB_len-1;
		String seq="";
			
		while( i != 0 && j != 0 )
		{
			
			if( this._OP[i][j].indexOf("supprimer") != -1 )
			{
				seq = this._OP[i][j] + ", " + seq;
				i--;
			}
			else if( this._OP[i][j].indexOf("ajouter") != -1 ) 
			{
				seq = this._OP[i][j] + ", " + seq;
				j--;
			}
			else if( this._OP[i][j].indexOf("echanger") != -1 )
			{
				seq = this._OP[i][j] + ", " + seq;
				i--;
				j--;
			}
			else if( this._OP[i][j].indexOf("rien") != -1 )
			{
				i--;
				j--;				
			}
		}
		
		return seq;
	}	
	
	public static void main(String[] ar)
	{
		String chaineA = "abbbcc";
		String chaineB = "abba";
		distanceLev dl = new distanceLevenstein(chaineA, chaineB);
	
		System.out.println("chaine A: "+chaineA);
		System.out.println("chaine B: "+chaineB);
		dl.doLevensteinDistance();
	
		System.out.println("Matrice C:");
		System.out.println(dl.getMatriceC());
	
		System.out.println("Nombre minimal d'operations pour passer de "+
							"'"+chaineA+"' a '"+chaineB+"': "+dl.getNbMinOperations());
	
		System.out.print("Operations a effectuer: ");
		System.out.println(dl.getMatriceOP());
		
	}
}
