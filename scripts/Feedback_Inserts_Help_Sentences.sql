delete from Help_Sentences;
ALTER TABLE Help_Sentences AUTO_INCREMENT = 1;

insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(2,'Agent_Role',1,'You can also say the argument is man in street racer armor.'),
(518,'Agent_Role',2,''),
(520,'Agent_Role',3,'');

insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(11,'Patient_Role',1,''),
(12,'Patient_Role',2,''),
(677,'Patient_Role',3,'this is the special case of Patient role, with To Be verb, patient is the described element of the verb (subject), not the object as in most of the cases.
Do not forget we think of the sentence from semantic perspective (what is affected of the verb) not from syntactic perspective (what is the subject or object of the verb).');


insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values--(3,'Attribute_Role',1,'Where (another racers motor bike) is the patient of the event'),
(678,'Attribute_Role',2,'');


insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(3543,'Material_Role',1,''),
(4063,'Material_Role',2,'');

insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(4192,'Beneficiary_Role',1,'the argument may also include (ball), this is minor boundary variation.');

insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(7302,'Recipient_Role',1,''),
(234,'Recipient_Role',2,'');

insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(4961,'Source_Role',1,''),
(5174,'Source_Role',2,'');

insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(5191,'Destination_Role',1,''),
(5205,'Destination_Role',2,'');

insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(522,'Instrument_Role',1,'');

insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(5261,'Time_Role',1,''),
(5296,'Time_Role',2,''),
(5300,'Time_Role',3,'');

insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(1,'Property_Role',1,''),
(5,'Property_Role',2,''),
(9,'Property_Role',3,''),
(22,'Property_Role',4,''),
(517,'Property_Role',5,''),
(881,'Property_Role',6,'');


insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(16,'Location_Role',1,'');



insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(14,'Property_-_Location_Confusion',1,'This relation might be confusing, either location or property, but it is more location than property.'),
(17,'Property_-_Location_Confusion',2,'This relation might be confusing, either location or property, but it is more location than property.'),
(18,'Property_-_Location_Confusion',3,'This relation might be confusing, either location or property, but it is more location than property.');


insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(156,'Destination_-_Location_Confusion',1,'This role might be patient of the turning event, other minds would see it (Location) of the turn, or (Destination) of it.'),
(46,'Destination_-_Location_Confusion',2,'From my personal view, this role might be Destination or location, other minds would prefer one of them, user is free in such ambiguous cases.');


insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(859,'Time_-_Location_Confusion',1,'This could be time or location. Both are correct based on the user understanding.'),
(861,'Time_-_Location_Confusion',1,'This could be time or location. Both are correct based on the user understanding.');


insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(5591,'Material_-_Property_Confusion',1,'This role could be material or property according to the understanding, both might be correct.');


insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(221,'Attribute_-_Location_Confusion_with_to_be_verb',1,''),
(222,'Attribute_-_Location_Confusion_with_to_be_verb',2,'');


insert into Help_Sentences (triple_id,group_name,order_index,help_comment)
values(206,'Common_Mistakes',1,'This is a common mistake, this relation is wrong because the argument does not complete the meaning of the location of the predicate.'),
(513,'Common_Mistakes',2,'This is a common mistake, the tennis ball is not the location of the person.'),
(2124,'Common_Mistakes',3,'This is not the material of (grind), but it is the instrument of the event, so this relation should have a role (Instrument) instead of (Material).');
--(910,'Common_Mistakes',4,'This is a common mistake, this relation is wrong because the argument does not complete the meaning of the location of the predicate.');

