var ingredientIdNum = 5;             //no. of ingredients on page + 1
var stepIdNum = 5;                   //no. of steps on page + 1
var friends = 0;                     //no. of friends
var isFriendly = false;

//adds ingredient input to page
function addIngredientField() {
    var allIngredients = document.getElementsByClassName("ingredient");
    var lastIngredient = allIngredients[allIngredients.length - 1];
    var clone = lastIngredient.cloneNode(true);
    clone.id= "ingredient" + ingredientIdNum;
    lastIngredient.parentNode.appendChild(clone);
    fixIngredientInputName();
}

//adds ingredient input to page with a value
function addIngredientFieldWithValue(val)
{
    addIngredientField();
    fixIngredientValue(val);
}

//fix ingredient input value to page
function fixIngredientValue(val)
{
    var allIngredientInputs = document.getElementsByClassName("ingredientInput");
    var lastIngredientInput = allIngredientInputs[allIngredientInputs.length - 1];
    lastIngredientInput.value = val;
}

//fixes the last added ingredient's name
function fixIngredientInputName()
{
    var allIngredientInputs = document.getElementsByClassName("ingredientInput");
    var lastIngredientInput = allIngredientInputs[allIngredientInputs.length - 1];
    lastIngredientInput.name = "ingredient" + ingredientIdNum++;
    lastIngredientInput.value = "";
}

//adds step input on page
function addStepField() {
    var allSteps = document.getElementsByClassName("step");
    var lastStep = allSteps[allSteps.length - 1];
    var clone = lastStep.cloneNode(true);
    clone.id= "step" + stepIdNum;
    lastStep.parentNode.appendChild(clone);
    fixStepInputName();
}

function addStepFieldWithValue(val)
{
    addStepField();
    fixStepValue(val);
}

function fixStepValue(val)
{
    var allStepInputs = document.getElementsByClassName("stepInput");
    var lastStepInput = allStepInputs[allStepInputs.length - 1];
    lastStepInput.value = val;
}

//fixes the last added step's name
function fixStepInputName()
{
    var allStepInputs = document.getElementsByClassName("stepInput");
    var lastStepInput = allStepInputs[allStepInputs.length - 1];
    lastStepInput.name = "step" + stepIdNum++;
    lastStepInput.value = "";
}

//check if the privacy is set to friendly and add input fields
function checkFriendly()
{
    var privacyDropdown = document.getElementById("privacy");
    var selectedString = privacyDropdown.options[privacyDropdown.selectedIndex].value;

    if (selectedString == "friendly")
    {
        isFriendly = true;
        var privacyInput = document.getElementById("privacy-input");
        privacyInput.insertAdjacentHTML( 'beforeBegin', '<p id="friendText">Enter the email address of your friends:</p>' );
        addFriendInput();
        document.getElementById("addFriend").style.visibility='visible';
    }
    else
    {
        removeInputs();
        friends = 0;
        document.getElementById("addFriend").style.visibility='hidden';
        var friendText = document.getElementById("friendText");
        if (friendText != null)
        {
            var parent = friendText.parentNode;
            parent.removeChild(friendText);
        }
        isFriendly = false;

    }
}

//add more friend input on page
function addFriendInput()
{
    var newTextBox = document.createElement("input");
    newTextBox.setAttribute("type", "text");
    newTextBox.setAttribute("name", "friendName" + friends);
    newTextBox.setAttribute("placeholder", "Enter Friend Email Here");
    newTextBox.setAttribute("id", "friendName" + friends++);
    newTextBox.style.width = '100%';
    newTextBox.style.display = 'block';
    var containerDiv = document.getElementById("privacy-input");
    containerDiv.appendChild(newTextBox);
}

function addFriendInputWithVal(val)
{
    var newTextBox = document.createElement("input");
    newTextBox.setAttribute("type", "text");
    newTextBox.setAttribute("name", "friendName" + friends);
    newTextBox.setAttribute("placeholder", "Enter Friend Email Here");
    if (friends == 0)
    {
        newTextBox.required = "required";
    }
    newTextBox.setAttribute("id", "friendName" + friends++);
    newTextBox.style.width = '100%';
    newTextBox.style.display = 'block';
    newTextBox.value = val;
    var containerDiv = document.getElementById("privacy-input");
    containerDiv.appendChild(newTextBox);
}

//remove all friend input on page
function removeInputs()
{
    var i;
    for (i = 0; i < friends; i++)
    {
        var currFriendInput = document.getElementById("friendName" + i);
        var parent = currFriendInput.parentNode;
        parent.removeChild(currFriendInput);
    }
}

//validate form before submission
function validateForm()
{
    if (checkNameInput()
        && checkIngredientInputs()
        && checkStepInputs()
        && checkFriendInputs()
        && confirmSubmission())
    {
        return true;
    }
    else
    {
        return false;
    }
}

//recipe name can not be empty
function checkNameInput()
{
    var recipeName = document.getElementById("recipe-name").value;
    if (recipeName.trim() === "")
    {
        alert("Recipe name can not be empty!");
        return false;
    }
    return true;
}


//must have at least one ingredient 
function checkIngredientInputs()
{
    var i;
    var emptyIngredients = true;
    for (i = 1; i < ingredientIdNum; i++)
    {
        var currIngredient = document.getElementById("ingredient" + i).value;
        if (currIngredient.trim() != "")
        {
            emptyIngredients = false;
        }
    }

    if (emptyIngredients)
    {
        return false;
    }

    return true;
}

//must have at least one step
function checkStepInputs()
{
    var emptySteps = true;
    for (i = 1; i < stepIdNum; i++)
    {
        var currStep = document.getElementById("step" + i).value;
        if (currStep.trim() != "")
        {
            emptySteps = false;
        }
    }

    if (emptySteps)
    {
        return false;
    }
    return true;
}

//must have at least one friend email address if 'friendly'
function checkFriendInputs()
{
    var emptyFriends = true;
    if (isFriendly)
    {
        var i;
        for (i = 0; i < friends; i++)
        {
            var currFriend = document.getElementById("friendName" + i).value;
            //check if empty
            if (currFriend.trim() != "")
            {
                emptyFriends = false;

                //check if valid format
                var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                if (!re.test(currFriend))
                {
                    alert("'" + currFriend + "' is not a valid email address.");
                    return false;
                }
            }
        }

        if (emptyFriends)
        {
            alert("You must specify at least one friend for 'FRIENDLY' privacy." +
                  "\nYou can use 'PRIVATE' privacy, if you want the recipe hidden." +
                  "\nYou can change this later using 'Edit Recipe'.");
            return false;
        }
    }
    return true;
}

function confirmSubmission()
{
    var recipeName = document.getElementById("recipe-name").value;
    if (confirm("Are you sure you want to create recipe '" + recipeName + "'?"))
    {
        return true;
    }
    else
    {
        return false;
    }
}