delete from Help_Description;

ALTER TABLE Help_Description AUTO_INCREMENT = 1;

insert into Help_Description (group_name,description) values ('Agent_Role','This role is associated only with verb predicates. The agent links a verb (as a predicate) and the doer of it (as an argument).
<br>-Example: The man kicks the ball<br>-Predicate: kicks<br>-Role: Agent<br>-Argument: man');
insert into Help_Description (group_name,description) values ('Patient_Role','This is also relevant to verbs predicates only. It mentions the relation between the verb and the affected entity by such verb.
<br>-Example: The racer examines the motor<br>-Predicate: examines<br>-Role: Patient<br>-Argument: motor');
insert into Help_Description (group_name,description) values ('Attribute_Role','It is a verb-predicate relation. <br>
1- the description of "To be" verb:<br>-Example: The Mountain is Hugh<br>-Predicate: is<br>-Role: Attribute<br>-Argument: Hugh');
insert into Help_Description (group_name,description) values ('Material_Role','It could be attached to a verb-predicate or noun predicate. In the case of verb-predicate, the relation represents the materials used in the action:
<br>-Example: He builds the bridge out of wood<br>-Predicate: builds<br>-Role: Material<br>-Argument: wood <br><br>
In noun-predicate case, the relation indicates the material of the predicate (noun).
<br>-Example: This woody chair is expensive<br>-Predicate: chair<br>-Role: Material<br>-Argument: woody');
insert into Help_Description (group_name,description) values ('Beneficiary_Role','It is a verb-predicate. It states the goal of the action, the entity for whom the verb is running.
<br>-Example: I made a cake for my family<br>-Predicate: made<br>-Role: Goal (Beneficiary)<br>-Argument: my family');
insert into Help_Description (group_name,description) values ('Recipient_Role','It is a verb-predicate. With transfer verbs, it represent the final entity of the transfer.
<br>-Example: I gave Julia the book<br>-Predicate: gave<br>-Role: Recipient<br>-Argument: Julia');
insert into Help_Description (group_name,description) values ('Source_Role','In the case of movement verbs, this is the link between the verb and its source location.
<br>-Example: He drove last night from Hamburg to Berlin<br>-Predicate: drove<br>-Role: Source<br>-Argument: Hamburg');
insert into Help_Description (group_name,description) values ('Destination_Role','In the case of movement verbs, this is the link between the verb and its destination location.
<br>-Example: He drove last night from Hamburg to Berlin<br>-Predicate: drove<br>-Role: Destination<br>-Argument: Berlin');
insert into Help_Description (group_name,description) values ('Instrument_Role','It is a verb-predicate, it represents the instrument used to execute the action (verb).
<br>-Example: He wakes up usually with the morning alarm<br>-Predicate: wakes<br>-Role:Instrument<br>-Argument: the morning alarm');
insert into Help_Description (group_name,description) values ('Time_Role','It is a verb-predicate, it states the time of the verb action.
<br>-Example: He drove last night from Hamburg to Berlin<br>-Predicate: drove<br>-Role: Time<br>-Argument: last night');
insert into Help_Description (group_name,description) values ('Property_Role','It links a noun predicate with an argument that is a property of the predicate, or owned by the predicate.
<br>-Example: The girl with white t-shirt has just left the meeting<br>-Predicate: girl <br>-Role: Property<br>-Argument: white t-shirt');
insert into Help_Description (group_name,description) values ('Location_Role','This role could be attached to verb or noun predicates. It indicates the location of the execution of the action or the location of a noun predicate.
In in the first case, the verb acts as a predicate, the actual location phrase acts as argument. 
<br>-Example: The car is up on a carjack<br>-Predicate: is<br>-Role: Location<br>-Argument: up on a carjack<br><br>
On the hand in the second case, the only change is in the predicate part where the entity (we state its location) fills that position.
<br>-Example: The man in the garden<br>-Predicate: man<br>-Role: Location<br>-Argument: in the garden');


insert into Help_Description (group_name,description) values ('Destination_-_Location_Confusion','This confusion happends in some cases where the sentence could be cognitivly understood in different meanings. 
In such cases we leave the decision to the user who gives the feedback either using any of the two roles. If you find existing relation with a sensible role, please confirm it. If you find not correct, please reject it and introduce the new one (if not already introduced by another user). 
<br>-Example: The boy jumps in Air<br>-Predicate: jumps<br>-Role: Destination or Location<br>-Argument: in Air');

insert into Help_Description (group_name,description) values ('Time_-_Location_Confusion','This confusion happends in some cases where the sentence could be cognitivly understood in different meanings.
In such cases we leave the decision to the user who gives the feedback either using any of the two roles. If you find existing relation with a sensible role, please confirm it. If you find not correct, please reject it and introduce the new one (if not already introduced by another user).
<br>-Example: During the race, racer is examining his motor bike<br>-Predicate: examining<br>-Role: Time or Location<br>-Argument: the race');

insert into Help_Description (group_name,description) values ('Property_-_Location_Confusion','This confusion happends in some cases where the sentence could be cognitivly understood in different meanings.
In some cases the sentence is very close to one of the roles<br>
<br>-Example: The man in racing uniforms kicks the ball<br>-Predicate: man<br>-Role: Property<br>-Argument: racing uniforms<br>
<br>-Example: The man in a small race ....<br>-Predicate: man<br>-Role: Location<br>-Argument: a small race<br><br>
In other cases we leave the decision to the user who gives the feedback either using any of the two roles. If you find existing relation with a sensible role, please confirm it. If you find not correct, please reject it and introduce the new one (if not already introduced by another user');


insert into Help_Description (group_name,description) values ('Material_-_Property_Confusion','This confusion happends in some cases where the sentence could be cognitivly understood in different meanings. 
In such cases we leave the decision to the user who gives the feedback either using any of the two roles. If you find existing relation with a sensible role, please confirm it. If you find not correct, please reject it and introduce the new one (if not already introduced by another user). 
<br>-Example: The Woody bridge ....<br>-Predicate: bridge<br>-Role: Material or Property<br>-Argument: Woody<br>
<br>-Example: The black bridge ....<br>-Predicate: bridge<br>-Role: Property<br>-Argument: black');

insert into Help_Description (group_name,description) values ('Attribute_-_Location_Confusion_with_to_be_verb','This confusion is a special case! in case of "To Be" verb (main not auxiliary verb), you can attach only two semantic roles with a relation that has "To Be" predicate.
<br>1-Attribute: to state the description of the verb<br>
<br>-Example: The building is extremely High<br>-Predicate: is<br>-Role: Attribute<br>-Argument: extremely High<br><br>
2-Location:to state the location of the verb<br>
-Example: The building is in the background<br>-Predicate: is<br>-Role: Location<br>-Argument: in the background<br><br>');


insert into Help_Description (group_name,description) values ('Common_Mistakes','This a list of observed mistakes, we would like to explain examples of them.');
