cb.resourceSelectInput v2
=========================

ResourceSelectInput V2 - Custom Input type for modmore contentBlocks
V2 is a complete Rewrite of the Inputtype and is not compatible with V1.

Resource Select Box with childs of selected parent resource. 
You can filter the select box and use a bunch of new Options to prefilter the Resources to your wishes. 
This Input can be used to display resource data inside another resource in combination with getResourceField.
A custom input type for modmore's great modx extra Content Blocks.

How to install:
===============
- Copy the folders assets & core to your modx installation folder.
- Create a plugin with the content of resourceselectinput.plugin.php and trigger on ContentBlocks_RegisterInputs event.
- You are Done - Go and create your field with inputtype ResourceSelect.


Available Inputtype Backend Options
===================================

**Limit Context (YES/NO) - *default yes***

- Set to yes to Limit to current context of the block or no to select from all available contexts


**Limit Resources (Number) - *default empty***

- Limit maximum amount of resources to return


**Filter Templates (TEMPLATE IDS) - *default 0***

- include only templates from specified resources (csv), i.E. 1,6,8


**Sortfield (FIELDNAME) - **default pagetitle****

- Enter field to sort by i.E. publishedon,template,pagetitle or id


**Sortorder (ASC/DESC) - *default ASC***

- Enter ASC or DESC 


**Where (JSON) - *default empty***

- enter json where to add to the query i.E.

include only published IDs [{"published":"1"}]

include from Parent IDs [{"parent:IN":[34,56]}]

include IDs [{"id:IN":[68,69]}]

exclude Page by Title [{"pagetitle:!=":"Home"}]

exclude IDs [{"id:NOT IN":[67,68,69]}

