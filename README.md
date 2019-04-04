# user-management-system
Internations Coding Challenge

**Kostas asked me to note that I had no experience prior to last Thursday 28.03 in PHP or Symfony.**

Required Methods:  
  * addUser -> POST /api/user  {"name":name, "username":username}  
  * deleteUser -> DELETE /api/user/{id}  
  * assignUserToGroup -> POST /api/membership/{users_id}/{groups_id}  
  * removeUserFromGroup -> DELETE /api/membership/{users_id}/{groups_id}  
  * addGroup -> POST /api/group  {"name":group_name}  
  * deleteGroup -> DELETE /api/group/{id}  
  
Additional Methods:  
  * getUsers -> GET /api/user  
  * getGroups -> GET /api/groups  

![alt text](https://github.com/lydonjake/user-management-system/blob/master/diagrams/Domain_Model.jpeg)
  
![alt text](https://github.com/lydonjake/user-management-system/blob/master/diagrams/ERD.jpeg)
