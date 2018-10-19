
create table  wht_book (
    id bigint(32) not null  AUTO_INCREMENT primary key,
    book_name varchar(50) not null comment '书籍名称',
    book_auther varchar(32) not null  comment '书籍作者',
    book_img varchar(255) not null  comment '书籍图片',
    book_desc text comment '书籍介绍',
    book_type int(11) not null  default  99 comment '书籍类型 99其他',
    view_num int(11) not null default  0 comment '浏览量',
    click_num int(11) not null default  0 comment '点击量',
    follow_num int(11) not null default 0 comment '关注量',
    sort int(11) not null default  9999 comment '升序排列',
    word_num bigint(32) not null default  0 comment  '书籍字数',
    key_word varchar(255)  not null  default '' comment  '书籍关键字',
    auther_uid bigint(32) not null default 0 comment '书籍作者userid',
    is_update tinyint(1) not null  default 0 comment '更新状态0未更新1已更新',
    is_over tinyint(1) not null  default 0 comment '连载状态0连载中1已完结2断更',
    is_pay tinyint(1) not null  default 0 comment '付费状态0不付费1付费2部分付费',
    nav_recommend tinyint(10) not null default 0 comment '首页推荐0未推荐1推荐',
    is_display tinyint(1) not null default 1 comment '1显示0不显示',
    new_chapter varchar(255)  default  null comment '最新章节名称',
    chapter_id bigint(32)  default  0 comment '最新章节id',
    update_time datetime default  null  comment '创建时间',
    create_time datetime not  null  comment '创建时间'

)ENGINE=myisam  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci comment '书籍信息表';


insert into  wht_book (book_name,book_auther,book_img,book_desc,create_time) values ('大秦列传','冉海','www.baidu.com','henhaoknde','2018-12-11 11:10:11');

create table wht_type(
    id int(32) not null  AUTO_INCREMENT primary key,
    type_name varchar(32) not null  comment '类型名称',
    type_desc varchar(255) not null comment '类型介绍',
    state tinyint(2) not null default 0 comment '0使用1停用',
    sort int(11) not null default 99999 comment '升序排列',
    create_time datetime not null ,
    update_time datetime default  null
)ENGINE=myisam  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci comment '书籍类型表';


insert  into  wht_type (type_name,type_desc,sort,create_time) values ('玄幻魔法','玄幻／/魔法系列',1,'2018-09-22 21:50:09');
insert  into  wht_type (type_name,type_desc,sort,create_time) values ('历史军事','历史军事／穿越',2,'2018-09-22 21:50:09');
insert  into  wht_type (type_name,type_desc,sort,create_time) values ('奇幻修真','历史军事／穿越',3,'2018-09-22 21:50:09');


create table wht_book_chapter(
  chapter_id bigint(32) not null  comment '章节id',
  book_id bigint(32) not null comment '书籍ID',
  chapter_name varchar(255) not null comment '章节名称',
  content_path varchar(255) not null comment '内容路径',
  is_pay  tinyint(1) not null default 0 comment '0不付费1付费',
  pay_money int(11) not null default  0 comment '付费金额以分为单位',
  is_display tinyint(1) not null default 1 comment '1显示0不显示',
  state tinyint(1) not null  default 1 comment '下载成功1未成功0',
  spider_url varchar(255) not  null  comment '下载url',
  create_time datetime not null,
  update_time datetime default  null

)ENGINE=myisam  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci comment '书籍章节表';


insert into wht_book_chapter(chapter_id,book_id,chapter_name,create_time,content_path) values (1,1,'金柯刺秦','2018-12-11 11:01:11','/ll/a.txt');

create table wht_spider_log(
  id bigint(32) not null AUTO_INCREMENT primary key,
  spider_id int(11) not null  comment '爬虫id',
  book_id bigint(32)  not null default 0 comment '爬取书籍',
  book_type int(11) not null comment '分类类型',
  status tinyint(1) not null default 1 comment '爬取类型1分类0书籍',
  state tinyint(1) not null default  1 comment '是否爬取成功1成功0未成功',
  spider_url varchar(255) not null  comment  '爬取URL',
  spider_url_hash varchar(32) not null unique comment 'url hash 唯一',
  spider_chapter_id bigint(32) not null default 0 comment '爬取最新章节',
  remark text comment '采集错误信息',
  create_time datetime not null,
  update_time datetime default null
)ENGINE=myisam  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci comment '爬虫书籍记录表';



create table wht_spider_hash_log(
  spider_url_hash varchar(32) not null  comment 'url hash 唯一',
  spider_chapter_url varchar(255) not null comment '章节url'

)ENGINE=myisam  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci comment '爬虫去重表';



insert into wht_spider_log (spider_id,book_type,spider_url,spider_url_hash,create_time)
values (1,1,'https://www.x23us.com/class/1_1.html','uuuuu','2018-09-21 12:11:10');

create table wht_spider_setting(
  id int(11) not null AUTO_INCREMENT primary key,
  spider_name varchar(32) not null  comment '爬虫名称',
  spider_key_word varchar(32) not null comment '爬虫关键字',
  page_start int(11) not null default 0 comment '爬取开始页码',
  page_end int(11) not null default 0 comment '爬取结束页码',
  book_type int(11) not null  comment '爬取类型',
  finsh_page int(11) not null default 0 comment '已完成页码',
  spider_url varchar(255) default null comment '爬取url',
  spider_config varchar(255) not null comment '配置文件',
  create_time datetime not null,
  update_time datetime default  null

)ENGINE=myisam  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci comment '爬虫配置';

insert  into wht_spider_setting(spider_name,spider_key_word,page_start,page_end,book_type,spider_config,create_time) values ('顶点小说','DingDian',1,10,1,'book.DingDian','2018-09-21 12:11:10')





