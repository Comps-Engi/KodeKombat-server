/*
 * Use ActiveRecord conventions
 */

drop table if exists 'bots';
create table 'bots' (
  'id' int(10) not null auto_increment,
  'filesize' int(30) not null,
  'filetype' varchar(10) not null,
  'user_id' int(10) not null,
  'timestamp' timestamp not null default current_timestamp,
  'code' blob not null,
  'sflag' int(11) default null,
  'rflag' int(11) default null,
  'token' int(11) default null,
  'score' int(11) default null,
  'q' double default null,
  primary key ('id'),
  key 'user_id' ('user_id'),
  constraint 'bot_ibfk_1' foreign key ('user_id') references 'users' ('id') on delete cascade on update cascade
) engine=innodb auto_increment=24 default charset=latin1;


drop table if exists 'users';

create table 'users' (
  'id' int(11) not null,
  'name' varchar(255) not null,
  'email' varchar(255) not null,
  'contact' varchar(31) default null,
  'uname' varchar(255) not null,
  'passwd' varchar(255) not null,
  'type'   varchar(30) default 'user',
  primary key ('id'),
  unique key 'uname' ('uname')
) engine=innodb default charset=latin1;

drop table if exists 'matches';

create table 'matches' (
  'id' int(10) not null,
  'player_one_id' int(10) not null,
  'player_two_id' int(10) not null,
  'trace' mediumblob,
  'result' bit(1) default null,
  primary key ('id' )
) engine=InnoDB default charset=latin1;
