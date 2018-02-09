# Scripto blog week 4
A blog application to share your writings and comments with the world!

An additional version to the previous Scripto blog application of last week (See the repository Scripto-Blog-Application) with new features based on the userstories as described in the CodeGorilla assignment of week 4 (discussed down below) and a working online demo.

The repository includes the normal version (Scripto4) and the version for the online demo (Scripto 4 Webversie).

## Follow the progression: https://trello.com/b/sZldGU2x/scripto-week-2

## Description of the application
The application includes for html pages: "blogs", "categoriën", "Schrijf zelf" en "Commentaar"
- "Blogs" shows all the blogs published with the most recent on top. 
The button on the bottom of the page refreshes the blogs with the most recent blogs posted since the page was loaded.
- "Categoriën" gives five buttons on top of the page, one for each standard category. When selected all the blogs of a certain category are loaded with the most recent blog on top.
- "Schrijf zelf" gives the user the opportunity to write a blog, including author, title, category (a second category) and the blog text itself. With the button on the bottom of the page the blog is published and send to the database. From that moment the blog is visible on the "Blogs" and "Categoriën" pages.
- "Commentaar" gives the user the opportunity to leave a comment at a certain blog post and read other comments linked to a certain blog. On the bottom of the page the user can give the id of a comment he/she wants to delete and the user can give the title of a blog to shutdown its comment section for the rest of the session. To block a comment section permanently, the title of a blog can be written in the code of comment4.html As an example, the blog "Openingsblog" has a permanent blocked comment section.

### Workflow
- Monday: reading assignment, recycle version blog last week, first version text-expander
- Tuesday: first version comment section, add comments to database
- Wednesday: made deletion of comment possible, trying to make first online demo working
- Thursday: made two categories for blog possible, disable comments per blog possible, new version of online demo  
- Friday: made blog more user-friendly, new version online demo, improved readme Github, fixed bugs

## Look for the latest online demo at: http://wijzijncodegorilla.nl/jorik/Scripto4/

## Userstories
The Userstories of the CodeGorilla assignment for week 3 (in Dutch):
- ID     Als een:    Wil ik:
- W3-001 Blogger:    Artikelen op mijn blog plaatsen.  
- W3-002 Lezer:      Een overzicht hebben van de artikelen die mijn favoriete blogger heeft geschreven met het meest recente artikel bovenaan.
- W3-003 Blogger:    Een artikel aan één categorie kunnen koppelen.
- W3-004 Lezer:      Alleen de artikelen in een bepaalde categorie kunnen selecteren met behulp van een kolom.
- W3-005 Blogger:    Zelf categorieën kunnen toevoegen.
- W3-006 Blogger:    Meerdere categorieën kunnen koppelen aan een artikel
- W3-007 Blogger:    De tekst in het artikel kunnen formateren (bijv. vet gedrukt of cursief maken)
- W3-008 Blogger:    Een afbeeldingen in een artikel kunnen plaatsen.

The Userstories of the CodeGorilla assignment for week 4 (in Dutch):
- ID     Als een:    Wil ik:
- W4-001 Blogger:    Een text-expander die als ik een artikel aan het schrijven ben door mij zelf gedefinieerde afkortingen die ik type direct omzet in de volledige tekst.
- W4-002 Lezer:      Anoniem commentaar kunnen geven op een artikel.
- W4-003 Lezer:      Artikelen in een bepaalde categorie kunnen selecteren met behulp van een kolom zonder dat de pagina opnieuw wordt ingelezen.
- W4-004 Blogger:    Ongewenst commentaar kunnen verwijderen.
- W4-005 Blogger:    Voor een artikel kunnen instellen dat geen commentaar kan worden gegeven.

## Finished userstories
- W3-001
- W3-002
- W3-003
- W3-004
- W3-006 (Note: A blog can have a maximum of two categories)

- W4-001
- W4-002
- W4-003
- W4-004
- W4-005 (Note: Title can be put in hard code to be blocked permanently or in the user interface to be blocked for the length of the session)

### WORK IN PROGRESS
- W3-005

# Screenshots
![Alt text](https://github.com/JorikdeBoer/Scripto-blog-week-4/blob/master/Scriptoblogpage.png?raw=true "Scripto blog homepage")

![Alt text](https://github.com/JorikdeBoer/Scripto-blog-week-4/blob/master/Scriptocommentpage.png?raw=true "Scripto blog commentpage")
