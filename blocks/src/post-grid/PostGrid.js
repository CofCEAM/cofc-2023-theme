import { useSelect } from "@wordpress/data";
import { useState, useEffect } from "react";
function PostGrid({ attributes }) {
  console.log(attributes);
  const {
    categories,
    tags,
    useFullWidth,
    displayExcerpt,
    displayAuthor,
    displayPublishDate,
    limit,
    offset,
    columns,
    title,
    includeLink,
    linkUri,
    linkText,
    linkNewTab,
  } = attributes;
  const columnsToSizeClassMap = { 1: "medium-12", 2: "medium-6", 3: "medium-4", 4: "medium-3" };
  const postSizeClass = columnsToSizeClassMap[columns];
  const posts = useSelect(
    (select) => {
      return select("core").getEntityRecords("postType", "post", {
        categories: categories,
        tags: tags,
        per_page: limit,
        offset: offset,
      });
    },
    [categories, tags, offset, limit]
  );

  const [extendedPosts, setExtendedPosts] = useState([]);
  useEffect(() => {
    const extendPosts = async () => {
      if (posts) {
        Promise.all(
          posts.map(async (post) => {
            let featuredImage = null;
            let authorData = null;
            if ("wp:featuredmedia" in post._links && post._links["wp:featuredmedia"].length > 0) {
              let mediaItem = post._links["wp:featuredmedia"][0];
              if (mediaItem.embeddable) {
                featuredImage = await fetch(mediaItem.href).then((resp) => resp.json());
              }
            }
            if ("author" in post._links && post._links["author"].length > 0) {
              authorData = await fetch(post._links["author"][0].href).then((resp) => resp.json());
            }

            return {
              ...post,
              featuredImage: featuredImage,
              authorInfo: authorData,
            };
          })
        ).then((extended) => {
          console.log(extended);
          setExtendedPosts(extended);
        });
      }
    };
    extendPosts();
  }, [posts]);
  // Render the posts
  const wideClass = useFullWidth ? "card-news--wide" : "";
  return (
    <section className="news-content news-content--latest news-content--single component">
      <div class="cell xsmall-12 news-content__home">
        <h2 class="font-h2">{title}</h2>
        <hr />
      </div>
      <div class="news-content__cards grid-x grid-margin-x grid-margin-y">
        {extendedPosts && extendedPosts.length > 0 ? (
          extendedPosts.map((post) => (
            <div className={`cell xsmall-12 ${postSizeClass}`}>
              <div className={`card-news ${wideClass}`} itemScope itemType="https://schema.org/NewsArticle">
                <figure class="card-news__figure">
                  {post.featuredImage ? (
                    <img
                      src={post.featuredImage.source_url}
                      alt={post.featuredImage.alt_text}
                      className="card-news__image"
                      itemprop="image"
                      width="926"
                      height="695"
                    ></img>
                  ) : (
                    ""
                  )}
                </figure>
                <div className="card-news__wrapper">
                  <div class="card-news__content">
                    <p class="card-news__heading font-h4">
                      <span itemprop="headline">{post.title.rendered}</span>
                    </p>
                    {displayExcerpt ? <p className="rail-news__copy">{post.excerpt.raw}</p> : ""}
                    {displayPublishDate ? (
                      <p className="card-news__date card-icon">
                        <svg class="brei-icon brei-icon-calendar" focusable="false">
                          <use href="#brei-icon-calendar"></use>
                        </svg>
                        <span itemprop="dateline">
                          {new Date(post.date).toLocaleDateString("en-US", {
                            month: "long",
                            day: "numeric",
                            year: "numeric",
                          })}
                        </span>
                      </p>
                    ) : (
                      ""
                    )}
                    {displayAuthor ? (
                      <p className="card-news__author card-icon">
                        <svg class="brei-icon brei-icon-avatar" focusable="false">
                          <use href="#brei-icon-avatar"></use>
                        </svg>
                        <span itemprop="author">by {post.authorInfo.name}</span>
                      </p>
                    ) : (
                      ""
                    )}
                  </div>
                </div>
              </div>
            </div>
          ))
        ) : (
          <p>No posts found</p>
        )}
      </div>
      {includeLink && linkUri && linkText ? (
        <div class="button-dotted-line">
          <a href={linkUri} class="btn btn--primary">
            <span class="text">{linkText}</span>
          </a>
        </div>
      ) : (
        ""
      )}
    </section>
  );
}

export default PostGrid;
