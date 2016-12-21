<script>
function getSelected(str)
{
var elem = document.getElementById("statement_Type").getElementsByTagName("option");
var len = elem.length;
var sel = new Array();

for(i=0; i<len;i++)
{
    if(elem[i].selected == true)
  {
    sel.push(elem[i].value);
  }  
}

alert(sel.join());
alert(str);
}

</script>
<p>	please select statement type.

<select id="statement_Type" onchange="getSelected(this.value);">
  <option value="New">New</option>
  <option value="Reviewed">Reviewed</option>
  <option value="Ref_Example">Ref Example</option>
</select>

 <select multiple=multiple id="sel1" style="width: 200px;">
  <option selected="selected" value="1">1</option>
  <option value="2">2</option>
  <option selected="selected" value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option selected="selected" value="6">6</option>
</select>
<button onclick="getSelected();">Get Selected</button>
