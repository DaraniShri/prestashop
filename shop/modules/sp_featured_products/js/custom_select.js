var selectedValues= new Array();
$('#products').select2('val', ["value1", "value2", "value3"]);
selectedValues.push("value1");
selectedValues.push("value2");
selectedValues.push("value3");
$("#products[]").selectedValues(Values).trigger('change');

