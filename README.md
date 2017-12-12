# install

## postgresql create table

    create table qiita_tags (
        id serial primary key,
        name text not null,
        icon_url text ,
        followers_count integer not null,
        items_count integer not null,
        prev_items_count integer default 0 not null,
        created_at timestamp default now() not null,
        updated_at timestamp default now() not null
    )

## db dsnの編集

Dao.php line:17を編集してください
    self::$_db = new PDO("pgsql:dbname=*** host=*** port=***", "***", "***");
