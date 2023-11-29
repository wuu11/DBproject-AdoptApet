set AUTOCOMMIT = 0;
insert into userinfo values (000001, '123456', 1, 1),
(000002, '456789', 1, 1),
(100001, 'asdfgh', 0, 1),
(100002, 'qwerty', 0, 1),
(100003, '123456', 0, 1),
(100004, '555888', 0, 1);
commit;

set AUTOCOMMIT = 0;
insert into administrator values (1, 000001, 'Simon', 15512341234, 'Simon@petadmin.org'),
(2, 000002, 'Alex', 15612341234, 'Alex@petadmin.org');
commit;

set AUTOCOMMIT = 0;
insert into common_user values (1, 100001, 'Alice', 21, 'F', 13422225555, 'Alice@petuser.org', 'Guangdong,Shenzhen,Nanshan Liyuan'),
(2, 100002, 'Bruce', 26, 'M', 13533336666, 'Bruce@petuser.org', 'Guangdong,Shenzhen,Nanshan Pingshan Village'),
(3, 100003, 'Bob', 19, 'M', 17033336666, 'Bob@petuser.org', 'Guangdong,Shenzhen,Nanshan Xili'),
(4, 100004, 'Cindy', 24, 'F', 18956563232, 'Cindy@petuser.org', 'Guangdong,Shenzhen,Luohu Dongmen');
commit;

set AUTOCOMMIT = 0;
insert into variety values (1, 'Corgi', 'A kind of dog which has short legs and a fox-like head.'),
(2, 'Teddy', 'A kind of dog which has curly hair and meek character.'),
(3, 'Maine coon', 'A kind of cat which has long hair and strong physicue.'),
(4, 'Ragdoll', 'A kind of cat which has big eyes,thick hair and soft body.');
commit;

set AUTOCOMMIT = 0;
insert into pet values (1, 2, 1, 'Puppy', '2022-05-05', 1, 'M', 'brown', 'clever', 'good', 0, '2023-10-18 10:33:21'),
(2, 4, 1, 'Polly', '2021-12-23', 2, 'F', 'white', 'gentle', 'good', 1, '2023-10-21 08:25:27'),
(3, 1, 2, 'Taotao', '2023-08-31', 0, 'M', 'yellow', 'lively', 'good', 1, '2023-10-20 09:14:23'),
(4, 1, 2, 'Candy', '2021-11-17', 2, 'F', 'yellow', 'aggressive', 'good', 0, '2023-10-18 10:33:22'),
(5, 3, 1, 'Buddy', '2022-10-08', 1, 'M', 'grey', 'lazy', 'a little weak', 0, '2023-10-18 10:33:22'),
(6, 2, 1, 'Lily', '2023-03-01', 0, 'F', 'brown', 'naughty', 'good', 0, '2023-10-18 10:33:22');
commit;

set AUTOCOMMIT = 0;
insert into application values (1, 3, 1, 1, 1, '2023-10-19 10:32:07', '2023-10-20 09:14:23'),
(2, 2, 3, 1, 1, '2023-10-20 16:04:59', '2023-10-21 08:25:26'),
(3, 2, 4, 1, 2, '2023-10-20 18:12:49', '2023-10-21 08:26:07'),
(4, 1, 4, null, 0, '2023-10-23 14:07:35', null);
commit;

set AUTOCOMMIT = 0;
insert into adopt_record values (1, 1, '2023-10-20'),
(2, 2, '2023-10-21');
commit;

set AUTOCOMMIT = 0;
insert into review_record values (1, 1, 1, '2023-10-22', 'Pet gets along well with his owner.', '2023-10-22 17:01:46'),
(2, 2, 1, '2023-10-23', 'Pet likes her owner very much.', '2023-10-23 17:48:03');
commit;