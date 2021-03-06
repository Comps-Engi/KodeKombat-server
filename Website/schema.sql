/*
 * Use ActiveRecord conventions
 */

drop table if exists users;
create table users (
  id int(11) not null auto_increment,
  name varchar(255) not null,
  score int(11) not null default 0,
  email varchar(255) not null,
  contact varchar(31) default null,
  password varchar(255) not null,
  type   varchar(30) default 'user',
  constraint primary key (id),
  constraint unique key email_key (email)
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_bin;

drop table if exists bots;
create table bots (
  id int(12) not null auto_increment,
  filesize int(30) not null,
  filetype varchar(10) not null,
  user_id int(10) not null,
  timestamp timestamp not null default current_timestamp,
  filepath text not null,
  sflag int(11) default null,
  rflag int(11) default null,
  token int(11) default null,
  score int(11) default null,
  q double default null,
  constraint primary key (id),
  constraint foreign key (user_id) references users (id) on update cascade
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_bin;

drop table if exists matches;

create table matches (
  id int(10) not null auto_increment,
  timestamp timestamp not null default current_timestamp,
  player_one_id int(10) not null,
  player_two_id int(10) not null,
  trace mediumblob,
  result bit(1) default null,
  constraint primary key (id),
  constraint foreign key (player_one_id) references users (id) on update cascade,
  constraint foreign key (player_two_id) references users (id) on update cascade
) ENGINE=InnoDB CHARACTER SET utf8 COLLATE utf8_bin;
