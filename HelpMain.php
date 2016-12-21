<?php
// Start the session
session_start();
?>
<html>
<link rel="stylesheet" type="text/css" href="feedback.css">


<body>



<header>
<h1>Welcome to "Semantic Flickr Feedback" Project Help Page</h1>
</header>
<section>

<h1>What is "Semantic Flickr Feedback" Project?</h1>
<p>
Semantic Flickr Feedback (SFF) is a crowdsourcing project targets collecting human feedbacks on auto 
generated understanding of natural language sentences. The sentences we use were introduced by Flickr8k
 [1] project as a description of a set of pictures [2]. We automatically extract semantic relationships 
 from the sentences. Therefore, we run SFF project to get manual feedbacks on the extracted relations 
 in order to build a multi-level human-based corpus.
</p>
<p>
We use this web application to represent the initial understanding of the sentences, and collect feedback on them. 
A “triple” structure is our representation format of the semantic of the sentences (we discuss it in the next sections).
The user is able to confirm, disagree with the triples, moreover adding new ones.
</p>
<h2>The Semantic Relationships</h2>

<p>
As presented in fig 1, the triple format (represents a semantic relation) is constructed of 3 parts:
<ul>
<li>Predicate (entity/event): the predicate is the verb or noun you want to demonstrate your understanding about it, and attach a semantic relation.
It is the main element of the relation, and accordingly the other parts are attached.</li>
<li>Semantic Role: It states the relation’s type between the predicate and another word (or phrase) in the sentence (the argument).</li>
<li>Argument: It is the expression of word or a phrase that has the value of the argument the semantic relation.</li>
</ul>

<figure>
<img alt="triple format" src="imgs/triple_format.jpg">
<figcaption>Fig. 1: A triple from a sentence “Ali drives his bike on a rainy day.”</figcaption>
</figure>
<p>
Therefore, the predicate should be a noun or a verb in the sentence (only one word). 
The argument is a word or a phrase while the relation’s role represents the meaning of the link between 
them. As appeared in fig.1, a triple presents only a part of the sentence’s meaning; 
it states the predicate to be described, the argument, and the relation between them. 
The complete meaning of the sentence is indeed represented by a list of triples 
(examples are discussed in the next sections).
</p>
<p>
As long as the meaning of natural language sentences would expand to too many implicit and
explicit relationships between the words/phrases, we adopt VerbNet [3] thematic roles as a 
blueprint of out semantic roles. 
We have developed our new version of semantic roles.
The semantic relations are categorized into three groups:
<ul>
  <li>Verb related, where the predicate should be a verb
  <ul>
  	<li>Agent Relation<a href="Help_Details.php?Help=Agent_Role">Description/Examples</a></li>
  	<li>Patient Relation<a href="Help_Details.php?Help=Patient_Role">Description/Examples</a></li>
	<li>Attribute Relation<a href="Help_Details.php?Help=Attribute_Role">Description/Examples</a></li>
	<li>Beneficiary Relation<a href="Help_Details.php?Help=Beneficiary_Role">Description/Examples</a></li>
	<li>Recipient Relation<a href="Help_Details.php?Help=Recipient_Role">Description/Examples</a></li>
	<li>Source Relation<a href="Help_Details.php?Help=Source_Role">Description/Examples</a></li>
	<li>Destination Relation<a href="Help_Details.php?Help=Destination_Role">Description/Examples</a></li>
	<li>Instrument Relation<a href="Help_Details.php?Help=Instrument_Role">Description/Examples</a></li>
	<li>Time Relation<a href="Help_Details.php?Help=Time_Role">Description/Examples</a></li>
	
  	</ul>
  </li>
  <li>Noun related, where the predicate should be a noun
  	<ul>
  		<li>Property Relation<a href="Help_Details.php?Help=Property_Role">Description/Examples</a></li>
  	</ul>
  </li>
  
  <li>Verb/Noun related, where the predicate might be a verb or noun<ul>
  		<li>Location Relation<a href="Help_Details.php?Help=Location_Role">Description/Examples</a></li>
  		<li>Material Relation<a href="Help_Details.php?Help=Material_Role">Description/Examples</a></li>
	</ul>
  </li>
</ul>


<h2>Question: Some roles are similar, or??</h2>

<p>
Actually, the boundaries between some semantic roles are not so sharp. In some situation two roles are interchangeable . in other cases, they are so similar but not interchangeable .
Let's see some examples of the confusing roles:  
As presented in fig 1, the triple format (represents a semantic relation) is constructed of 3 parts:
<ul>
  	<li>Destination-Location Confusion<a href="Help_Details.php?Help=Destination_-_Location_Confusion">Description/Examples</a></li>
  	<li>Time-Location Confusion<a href="Help_Details.php?Help=Time_-_Location_Confusion">Description/Examples</a></li>
	<li>Property-LocationConfusion<a href="Help_Details.php?Help=Property_-_Location_Confusion">Description/Examples</a></li>
	<li>Material-Property Confusion<a href="Help_Details.php?Help=Material_-_Property_Confusion">Description/Examples</a></li>
	<li>Attribute-Location Confusion with verb "To Be"<a href="Help_Details.php?Help=Attribute_-_Location_Confusion_with_to_be_verb">Description/Examples</a></li>
	<li>Common mistakes we would like to state<a href="Help_Details.php?Help=Common_Mistakes">Description/Examples</a></li>
	</ul>
	
	
	
<h2>A Bit Bigger Example!!</h2>
<p> 
<figure>
<img alt="Example" src="imgs/Help_example.jpg">
<figcaption>Fig. 2: A list of triples of sentence “Ali drives a blue car from Berlin to Hamburg.”
</figcaption>
</figure>


<br>
As listed in figure2, the sentence is annotated by a list of semantic relations. The sentence might have more than one predicate. For each one, one or more relations are acceptable. Here we have two predicates:
<ul>
  <li>Verb-predicate “driving”: which is done by Ali (agent relation), the car is the element 
  which is driven (patient relation), and Berlin and Hamburg are the source and destination of 
  the predicate (source, destination relations).
   </li>
   <li>Noun-predicate “car”: on the other hand, we have a noun predicate. 
   As we have a little set of relations that fit noun-predicates, we need to care about attaching 
   relations to it. In the example, we understand a property of the car from a part “a blue car”. 
   Therefore, a property relation should be extracted as presented in fig 2.
	</li>
</ul>

<h2>Notes to be considered</h2>
<p> 
	<ul>
	<li>
	Not all the nouns and verbs of the sentence have to be predicates in relations. 
	As we see in this example, words like {Berlin, Hamburg, blue, extremely, fast} are not 
	predicates because no relation type fits them (from our research perspective). 
	However, they may/ may not play an argument role in other relations.
	</li>
	<li>
	Auxiliary verbs are ignored: in our example we have an auxiliary verb (is), 
	we don’t extract semantic relations of auxiliary verbs, but on the main verbs (driving).
	</li>
	<li>
	The boundary definition of the argument is really subjective. 
	You may think the correct argument of driving-patient relation should be “blue car” or 
	“a blue car” instead of just “car”. 
	Our research has no restricted guidelines in this point, so we leave it to the human 
	judgement especially when the user introduces new semantic relation. 
	However, it is a subjective decision, and the user has the freedom to define it, 
	we recommend the user not to reject the existing relations with some acceptable changes 
	of the boundary definition (as in example of “car” and “blue car”). In the case of crucial 
	changes of argument boundary in the extracted relations 
	(e.g. the patient is “a” instead of “a blue car”), we encourage the user to give 
	negative feedback on this relation and introduce a new one with persuasive argument.
	</li>
	
	<li>
	The default feedback for all the existing relations is “correct”, so the user should care 
	about changing the feedback of the existing relations (if he wants to reject it or not to give a 
	feedback), not only adding new relations.
	</li>
	<li>
	In adding new relation, concentrating on what is the predicate and what is the argument is so 
	critical and don’t exchange them (especially in the case of noun predicate).
	With a sentence “Girl in blue dress…” the predicate is “Girl”, the relation role is “Property”,
	 and “blue dress” is the argument. That’s because the dress is a property of the girl, not 
	 vice versa.
	</li>
	<li>
	However the user is able to create different relations separately, we do recommend the user not 
	to overlap several arguments in different relations using the same predicate. 
	For example: “The boy jumps in the air”. We can clearly see a relation with “jumps” as a predicate,
	 “in the air” is the argument, but is it a “Location”, or “Destination” relation? Here it depends 
	 on your personal understanding of the sentence. Theoretically, the user is able to make two 
	 different relations, one with location role, and the other with destination role. But according 
	 to what we have just mentioned, we don’t recommend to overlap arguments in different relations 
	 with same predicate. Therefore, we emphasize here to ask the user to decide first the role that 
	 “in the air” plays with “jumps” and choose only one relation to express, then express his most 
	 plausible understanding of the sentence. 
	On the other hand, If the sentence is “The boy jumps in the air in front of the mountain”, 
	it is totally agreeable feedback when you create two relations with same predicate as the following:
		<ul>
		<li>
		“jump” predicate, “Location” role, “in front of the mountain” argument.
		</li>
		<li>
		“jump” predicate, “Destination” role, “in the air” argument.
		</li>
		</ul>
		The agreeability here because the arguments of the two relations (with same predicate) 
		are not overlapped.
		
	</li>
	
	
	</ul>

<h2>User Manual</h2>	
<p>
For more description of the web application and how to use it, we refer to the complete
help user document, download from <a target="_blank" href="docs/Introduction to Semantic Flickr feedback.docx">here</a> 
</p>

<h2>Just want to check it and ask us to ignore your feedbacks!!</h2>
<p>
At the home page of SFF, the use needs to enter his name/ID to check the sentences and give his feedback.<br>
Any feedbacks with username starts with <font color="red">"SFF_Play" (e.g. SFF_Play123)</font>, will be cleared in our periodic clearance process.  
</p>

<p>

<a href="index.php">Home</a>

<div >
[1]M. Hodosh, P. Young and J. Hockenmaier, "Framing Image Description as a Ranking Task: Data, Models and Evaluation Metrics," Journal of Artificial Intelligence Research , pp. 853-899, 2013.<br> 
[2]M. Hodosh, P. Young and J. Hockenmaier, "Framing image description as a ranking task:data, models and evaluation metrics," 2013. [Online]. Available: http://nlp.cs.illinois.edu/HockenmaierGroup/Framing_Image_Description/KCCA.html.<br>
[3]K. Kipper, A. Korhonen, N. Ryant and M. Palmer, "Extending VerbNet with Novel Verb Classes," in Proceedings of the Fifth International Conference on Language Resources and Evaluation -- LREC'06, Genoa, Italy, 2006. 
</div>
</section>
<footer>

<?php include 'footer.php';?>
</footer>
</body>
