var ingredientIdNum = 2 ;

function addIngredientField() {
    var allIngredients = document.getElementsByClassName("ingredient");
    var lastIngredient = allIngredients[allIngredients.length - 1];
    var clone = lastIngredient.cloneNode(true);
    //clone.id= "ingredient" + ingredientIdNum;
    lastIngredient.parentNode.appendChild(clone);
    fixIngredientInputName();
}

//fixes the last added ingredient's name
function fixIngredientInputName()
{
    var allIngredientInputs = document.getElementsByClassName("ingredientInput");
    var lastIngredientInput = allIngredientInputs[allIngredientInputs.length - 1];
    lastIngredientInput.value = "";
}
