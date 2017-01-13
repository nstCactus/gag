/**
 * @author Alexis Bouhet/ Repris par mounir DJIAR
 * @version 16/09/09
 */

	//Tableau contenant toutes les ragles de validation d'un formulaire
	var rules = [];
	
	
	/**
	 * Teste la validation d'un champ
	 * @param id: id du champ du formulaire à verifier
	 * @param node: le noeud qu'il faut verifier
	 * @param regex: l'expression reguliere à verifier
	 * @param message: le message a afficher en cas de non verification de la regex
	 */
	function checkFieldValidation(id, node, regex, message)
	{
		//L'element du formulaire
		var element = document.getElementById(id);
		
		//On enregistre toutes les regles de validations du formulaire courrant
		rules.push([element, node, regex, message]);
		//Lorsque l'element a le focus		
		element.onfocus = function () 
		{			
			
			//Si le champs n'est pas vide, on check son etat
			if(element[node] != "")
			{
				showStateValidation(element, node, regex);
			}
						
			element.onkeyup = function () {
				showStateValidation(element, node, regex);
			};		
		};
		
		//Lorsque l'element n'a plus le focus
		element.onblur = function () {			
			
			//Si le champs n'est pas vide, on check son etat
			if(element[node] != "")
			{
				showStateValidation(element, node, regex);
				element.onkeyup = null;
			}			
		};
	}	
	
	/**
	 * Affichage de l'etat de la validation
	 * @param element: l'element à verifier
	 * @param node: le noeud qu'il faut verifier
	 * @param regex: l'expression reguliere à verifier
	 */
	function showStateValidation (element, node, regex) 
	{
		//Encadrer le champ
		element.style.borderStyle = "solid";
		element.style.borderWidth = "1px";
		
		//Si l'expression est verifiée = bord en vert
		if (regex.test(element[node])) 
		{
			element.style.borderColor = "#00FF55";
			return true;
		}
		else //Si l'expression n'est pas verifiée = bord en rouge
		{
			element.style.borderColor = "red";
			
			// Dans le cas d'un CK Editor (bidouille)
			if(element.style.visibility == "hidden")
				element.nextSibling.style.borderColor = "red";
			
			return false;
		}
	}
	
	/**
	 * Teste si le formulaire est valide
	 */
	function checkFormValidation ()
	{
		//Initialisation: tous les champs sont valides
		var allFieldsOk = true;
		
		//Message à afficher en cas d'exsistance d'au moins une erreur sur le formulaire (message par defaut)
		var message = "Un élément du formulaire est invalide.";
		
		//Le nombre de regles de validations
		var total = rules.length;
		//Parcours de toutes les regles
		for (var i = total-1; i>=0; i--)
		{						
			if (!showStateValidation(rules[i][0], rules[i][1], rules[i][2])) 
			{
				if (rules[i][3] != null)
				{
					message = rules[i][3];
				}
				allFieldsOk = false;
			}
		}
		return [allFieldsOk, message];
	}
		
	/**
	 * Verifie un formulaire et affiche l'alert
	 * @param form: le formulaire a checker
	 */
	function checkForm (form)
	{
		//Le resultat de la verif
		var result = checkFormValidation();
		
		//Si le formulaire est valide
		if (result[0])
		{			
			if (form != null)
			{
				//On valide l'envoi
				//form.submit();
			}				
		}
		else 
		{
			//On affiche le message d'erreur
			alert(result[1]);
		}
				
		return result[0];
	}
	
	/********************************************************************************/
	/* 						NOMBRE DE CHAR MAX DANS UN TEXTAREA						*/
	/********************************************************************************/
	function maxlength_textarea(id, crid, max)
	{
        var txtarea = document.getElementById(id);
        document.getElementById(crid).innerHTML=max-txtarea.value.length;
        txtarea.onkeypress=function(){eval('v_maxlength("'+id+'","'+crid+'",'+max+');');};
        txtarea.onblur=function(){eval('v_maxlength("'+id+'","'+crid+'",'+max+');');};
        txtarea.onkeyup=function(){eval('v_maxlength("'+id+'","'+crid+'",'+max+');');};
        txtarea.onkeydown=function(){eval('v_maxlength("'+id+'","'+crid+'",'+max+');');};
	}
	function v_maxlength(id, crid, max)
	{
        var txtarea = document.getElementById(id);
        var crreste = document.getElementById(crid);
        var len = txtarea.value.length;
        if(len>max)
        {
                txtarea.value=txtarea.value.substr(0,max);
        }
        len = txtarea.value.length;
        crreste.innerHTML=max-len;
	}