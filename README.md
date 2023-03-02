# GraphQL with API Platform Watch Project
This project aims at doing technology watch on graphql, configuration in a Symfony & Api Platform project.

## Installation

For start the project, simply run the command `docker-compose up -d` at the root of the project.

Enter the `elastic_symfony` container with command `docker exec -it graphql_symfony bash;`.

Install the dependencies with `composer install` in container.

Apply migrations with `sf doctrine:migrations:migrate`

Generate fixtures Books and Authors with `sf doctrine:fixtures:load`

Run project on `http://graphql-watch.loc:8013`

## Usage Example

Base url for all requests :  `http://graphql-watch.loc:8013/api/graphql`
 
Payload example for get item book :
```
{
  book(id: "api/books/1") {
    id
    title
    isbn
    description
    author {
      id
      name
      birthdate
    }
  }
}
```

Payload example for get collection books with totalCount items :
```
{
  books {
    edges {
      node {
        id
        title
      }
    }
    totalCount
  }
}
```

Payload example for get item author with his books items and totalCount books :
```
{
  author(id: "api/authors/1") {
    id
    name
    birthdate
    books {
      edges {
        node {
          id
          title
        }
      }
      totalCount
    }
  }
}
```