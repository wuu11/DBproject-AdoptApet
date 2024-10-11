/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2024/8/6 18:06:09                            */
/*==============================================================*/


/*drop trigger application_AFTER_APPROVE;

drop trigger record_BEFORE_INSERT;

drop procedure if exists pet_applied_times;

alter table administrator 
   drop foreign key FK_ADMINIST_USER_ADMI_USERINFO;

alter table adopt_record 
   drop foreign key FK_ADOPT_RE_APPLY_ADO_APPLICAT;

alter table application 
   drop foreign key FK_APPLICAT_APPLY_PET_PET;

alter table application 
   drop foreign key FK_APPLICAT_PROCESS_ADMINIST;

alter table application 
   drop foreign key FK_APPLICAT_PROPOSE_COMMON_U;

alter table common_user 
   drop foreign key FK_COMMON_U_USER_COMM_USERINFO;

alter table pet 
   drop foreign key FK_PET_PET_VARIE_VARIETY;

alter table pet 
   drop foreign key FK_PET_PUBLISH_ADMINIST;

alter table review_record 
   drop foreign key FK_REVIEW_R_ADOPT_REV_ADOPT_RE;

alter table review_record 
   drop foreign key FK_REVIEW_R_CREATE_ADMINIST;
   
alter table variety 
   drop foreign key FK_VARIETY_ADD_ADMINIST;

drop
table if exists viewAdoptInfo;

drop index idx_variety_name on variety;*/

/*==============================================================*/
/* Table: administrator                                         */
/*==============================================================*/
create table administrator
(
   administrator_id     smallint not null auto_increment  comment '',
   account              numeric(6,0) not null  comment '',
   full_name            varchar(40) not null  comment '',
   phone                numeric(11,0) not null  comment '',
   email                varchar(50)  comment '',
   primary key (administrator_id)
);

/*==============================================================*/
/* Table: adopt_record                                          */
/*==============================================================*/
create table adopt_record
(
   adopt_id             smallint not null auto_increment  comment '',
   application_id       smallint not null  comment '',
   adopt_time           date not null  comment '',
   primary key (adopt_id)
);

/*==============================================================*/
/* Table: application                                           */
/*==============================================================*/
create table application
(
   application_id       smallint not null auto_increment  comment '',
   pet_id               smallint not null  comment '',
   user_id              smallint not null  comment '',
   administrator_id     smallint  comment '',
   state                numeric(1,0) not null  comment '',
   propose_time         datetime not null  comment '',
   process_time         datetime  comment '',
   primary key (application_id)
);

/*==============================================================*/
/* Table: common_user                                           */
/*==============================================================*/
create table common_user
(
   user_id              smallint not null auto_increment  comment '',
   account              numeric(6,0) not null  comment '',
   full_name            varchar(40) not null  comment '',
   age                  smallint  comment '',
   sex                  char(1)  comment '',
   phone                numeric(11,0) not null  comment '',
   email                varchar(50)  comment '',
   personal_address     varchar(80)  comment '',
   primary key (user_id)
);

/*==============================================================*/
/* Table: pet                                                   */
/*==============================================================*/
create table pet
(
   pet_id               smallint not null auto_increment  comment '',
   variety_id           smallint not null  comment '',
   administrator_id     smallint not null  comment '',
   nickname             varchar(40) not null  comment '',
   birthday             date  comment '',
   age                  smallint  comment '',
   sex                  char(1) not null  comment '',
   colour               varchar(15) not null  comment '',
   personality          varchar(50)  comment '',
   health               varchar(50)  comment '',
   photo_path           varchar(100) not null  comment '',
   adopt_state          numeric(1,0) not null  comment '',
   last_update_time     datetime not null  comment '',
   primary key (pet_id)
);

/*==============================================================*/
/* Table: review_record                                         */
/*==============================================================*/
create table review_record
(
   review_id            smallint not null auto_increment  comment '',
   adopt_id             smallint not null  comment '',
   administrator_id     smallint not null  comment '',
   review_time          date not null  comment '',
   situation            text not null  comment '',
   create_time          datetime not null  comment '',
   primary key (review_id)
);

/*==============================================================*/
/* Table: userInfo                                              */
/*==============================================================*/
create table userInfo
(
   account              numeric(6,0) not null  comment '',
   password             varchar(20) not null  comment '',
   role                 numeric(1,0) not null  comment '',
   state                numeric(1,0) not null  comment '',
   primary key (account)
);

/*==============================================================*/
/* Table: variety                                               */
/*==============================================================*/
create table variety
(
   variety_id           smallint not null auto_increment  comment '',
   administrator_id     smallint not null  comment '',
   variety_name         varchar(40) not null  comment '',
   introduction         text  comment '',
   primary key (variety_id)
);

/*==============================================================*/
/* Index: idx_variety_name                                      */
/*==============================================================*/
create index idx_variety_name on variety
(
   variety_name
);

/*==============================================================*/
/* View: viewAdoptInfo                                          */
/*==============================================================*/
create VIEW  viewAdoptInfo
 as
select adopt_record.adopt_id, common_user.full_name, common_user.phone, common_user.personal_address, pet.pet_id, pet.nickname, variety.variety_name, adopt_record.adopt_time
from adopt_record, application, common_user, pet, variety
where adopt_record.application_id = application.application_id and application.user_id = common_user.user_id and application.pet_id = pet.pet_id and pet.variety_id = variety.variety_id;

alter table administrator add constraint FK_ADMINIST_USER_ADMI_USERINFO foreign key (account)
      references userInfo (account) on delete restrict on update restrict;

alter table adopt_record add constraint FK_ADOPT_RE_APPLY_ADO_APPLICAT foreign key (application_id)
      references application (application_id) on delete restrict on update restrict;

alter table application add constraint FK_APPLICAT_APPLY_PET_PET foreign key (pet_id)
      references pet (pet_id) on delete restrict on update restrict;

alter table application add constraint FK_APPLICAT_PROCESS_ADMINIST foreign key (administrator_id)
      references administrator (administrator_id) on delete restrict on update restrict;

alter table application add constraint FK_APPLICAT_PROPOSE_COMMON_U foreign key (user_id)
      references common_user (user_id) on delete restrict on update restrict;

alter table common_user add constraint FK_COMMON_U_USER_COMM_USERINFO foreign key (account)
      references userInfo (account) on delete restrict on update restrict;

alter table pet add constraint FK_PET_PET_VARIE_VARIETY foreign key (variety_id)
      references variety (variety_id) on delete restrict on update restrict;

alter table pet add constraint FK_PET_PUBLISH_ADMINIST foreign key (administrator_id)
      references administrator (administrator_id) on delete restrict on update restrict;

alter table review_record add constraint FK_REVIEW_R_ADOPT_REV_ADOPT_RE foreign key (adopt_id)
      references adopt_record (adopt_id) on delete restrict on update restrict;

alter table review_record add constraint FK_REVIEW_R_CREATE_ADMINIST foreign key (administrator_id)
      references administrator (administrator_id) on delete restrict on update restrict;
      
alter table variety add constraint FK_VARIETY_ADD_ADMINIST foreign key (administrator_id)
      references administrator (administrator_id) on delete restrict on update restrict;

DELIMITER ;;
create procedure pet_applied_times(in p_pet_id int, out p_applied_times int)
begin
    select application_id, user_id, propose_time
    from application
    where pet_id = p_pet_id;
    
    select count(*)
    from application
    where pet_id = p_pet_id
    into p_applied_times;
end;;
DELIMITER ;

DELIMITER ;;
create trigger application_AFTER_APPROVE
after update on application
for each row begin
if old.state != 1 and new.state = 1
then update pet set adopt_state = 1, last_update_time = now() where pet_id = new.pet_id;
insert into adopt_record (application_id, adopt_time) 
values(new.application_id, CURDATE());
end if;
end;; 
DELIMITER ;

create trigger record_BEFORE_INSERT
before insert on review_record
for each row set new.create_time = now();

