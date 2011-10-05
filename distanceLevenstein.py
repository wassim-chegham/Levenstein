#! /usr/bin/env python
# -*- coding: utf-8 -*-


# Class Levenstein

class distanceLevenstein:
	
	def __init__(self, strA, strB):
		self._strA = strA
		self._strB = strB
		self._strA_len = len(self._strA)
		self._strB_len = len(self._strB)
		self._C = {}
		self._OP = {}

	def getLevensteinDistance(self):
		""" initialisation """
		x = 0; y = 0; z = 0; l = 0; ai = ''; bj = '';
			
		# lignes
		for i in xrange(0, self._strA_len):
			self._C[i, 0] = i 

		
		# colonnes
		for j in range(1, self._strB_len):
			self._C[0, j] = j	 

		""" corps """
		for i in range(1, self._strA_len):
			for j in range(1, self._strB_len):

				x = self._C[i-1, j]+1
				y = self._C[i, j-1]+1
				
				ai = self._strA[i]
				bj = self._strB[j]
			
				if ai == bj :
					l = 0
				else :
					l = 1

				z = self._C[i-1, j-1]+l
				
				self._C[i, j] = min( x, min(y, z) )
				
				#----
				if self._C[i, j] == x:
					self._OP[i, j] = "supprimer('"+ai+"')"

				elif self._C[i, j] == y:
					self._OP[i, j] = "ajouter('"+bj+"')"
				
				else:
					
					if ai == bj:
						self._OP[i, j] = "rien()"

					else:	
						self._OP[i, j] = "echanger('"+ai+" avec "+bj+"')"							

	def getMatriceC(self):
		for i in range(0, self._strA_len, 1):
			for j in range(0, self._strB_len, 1):
				print self._C[i, j]
			
			print "\n"

	def getNbMinOperations(self):
		if self._strA_len > 0 and self._strB_len > 0:		
			return self._C[self._strA_len-1, self._strB_len-1]
		else:
			return 0
			
	def getMatriceOP(self):

		""" chaines vides """
		if self._strA_len <= 0 or self._strB_len <= 0:
			return "aucune"

		""" chaines non vides """
		i = self._strA_len-1
		j = self._strB_len-1
		seq = ""
			
		while  i != 0 and j != 0 :
			action = self._OP[i, j]
			
			if "supprimer" in action :
				seq = action + '\n' + seq
				i = i-1

			elif "ajouter" in action :
				seq = action + '\n' + seq
				j = j-1

			elif "echanger" in action :
				seq = action + '\n' + seq
				i = i-1
				j = j-1

			elif "rien" in action :
				i = i-1
				j = j-1	

		return seq;

	def debug_C(self):
		print "Matrice C"
		for i in range(self._strA_len):
			print self._C[i]	


	def debug_OP(self):
		print "Matrice OP"
		for i in range(self._strA_len):
			print self._OP[i]


if __name__ == "__main__":

	a = raw_input('Entrer chaine A: ')
	b = raw_input('Entrer chaine B: ')
	
	dl = distanceLevenstein(a, b)
	dl.getLevensteinDistance()

	print "-- DEBUT LEVENSTEIN --\n"	
	print "* Chaine A: "+a+"\n"
	print "* Chaine B: "+b+"\n"
	#dl.debug_C()
	#dl.debug_OP()
	print "* Nombre d'operations pour passer de '"+a+"' a '"+b+"': "+str(dl.getNbMinOperations())+"\n"
	print "* Operations: "
	print dl.getMatriceOP()
	print "-- FIN LEVENSTEIN --"		
	




