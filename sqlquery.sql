-- user login
-- 1. check if email exists and password match email
select * from 
(select distinct User.*,  Email.Email from AtlantaBeltline.Email 
	join AtlantaBeltline.User on AtlantaBeltline.Email.Username = AtlantaBeltline.User.Username) 
as T
where Email = 'jsmith@outlook.com' and Password = md5('jsmith123');


-- redirect1: user only
select * from 
(select distinct User.*,  Email.Email from AtlantaBeltline.Email 
	join AtlantaBeltline.User on AtlantaBeltline.Email.Username = AtlantaBeltline.User.Username) 
as T where is_employee = 'no' and is_visitor = 'no' and Email = '...';


-- redirect2 : admin only
SELECT DISTINCT * FROM
(SELECT * FROM 
	(SELECT DISTINCT User.*,  Email.Email FROM AtlantaBeltline.Email JOIN AtlantaBeltline.User ON AtlantaBeltline.Email.Username = AtlantaBeltline.User.Username) 
	AS T WHERE is_employee = 'yes' AND is_visitor = 'no'AND Email = 'jsmith@gatech.edu') AS R JOIN AtlantaBeltline.Employee ON R.Username = Employee.username;


-- get transit info

SELECT A.Type, A.Route, A.Price, A.num,A.Site_Name FROM 
	(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,count(*) as num FROM atlantabeltline.Transit 
	JOIN atlantabeltline.Site_Connect_transit 
	on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route 
    GROUP BY Route,Type) AS A
    JOIN 
    (SELECT * FROM atlantabeltline.Transit 
	JOIN atlantabeltline.Site_Connect_transit 
    USING(Type,Route)
    ) as B
    USING(Type,Route)


-- use email to retrieve username
SELECT Username  FROM atlantabeltline.Email WHERE Email = 'jsmith@outlook.com'

-- transit history
SELECT DISTINCT B.Transit_Date, B.Route, B.Type,B.Price FROM 
(SELECT A.Type, A.Route, A.Price, A.Site_Name, User_Take_Transit.Transit_Date, User_Take_Transit.Username FROM 
(SELECT atlantabeltline.Transit.Type, atlantabeltline.Transit.Route,Price,Site_Connect_transit.Site_Name FROM atlantabeltline.Transit 
				JOIN atlantabeltline.Site_Connect_transit 
				on Transit.Type = Site_Connect_transit.Type and Transit.Route = Site_Connect_transit.Route ) AS A
                JOIN User_Take_Transit Using(Type,Route) ) AS B
                WHERE Username = 'manager2'