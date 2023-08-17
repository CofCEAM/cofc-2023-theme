const MediaCarousel = ({ attributes }) => {
  console.log(attributes);

  const getYouTubeThumbnail = (videoLink) => {
    // Extract the video ID from the link
    const videoId = extractVideoId(videoLink);

    // Construct the thumbnail image URL
    const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;

    // Use the thumbnail URL as needed (e.g., display it in an image tag)
    return thumbnailUrl;
  };

  const extractVideoId = (videoLink) => {
    // Examples of valid YouTube video links:
    // - https://www.youtube.com/watch?v=dQw4w9WgXcQ
    // - https://youtu.be/dQw4w9WgXcQ

    let videoId = "";

    // Extract the video ID using regex
    const regex =
      /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|[^#]*[?&]v=|youtu\.be\/|embed\/?|\/v\/|\/e\/|watch\?v=|[^#]*[?&]v=))([a-zA-Z0-9_-]{11})/;
    const match = videoLink.match(regex);

    if (match && match[1]) {
      videoId = match[1];
    }

    return videoId;
  };

  const { title, description, mediaItems, includeLink, linkUri, linkText, linkNewTab } = attributes;

  return (
    /* keys 
    id, title, filename, url, link, alt, author, description, caption, name, status, uploadedTo, date, modified, menuOrder, mime, type, subtype, icon, dateFormatted, nonces, editLink, meta, authorName, authorLink, filesizeInBytes, filesizeHumanReadable, context, height, width, orientation, sizes, compatid, title, filename, url, link, alt, author, description, caption, name, status, uploadedTo, date, modified, menuOrder, mime, type, subtype, icon, dateFormatted, nonces, editLink, meta, authorName, authorLink, filesizeInBytes, filesizeHumanReadable, context, height, width, orientation, sizes, compatid, title, filename, url, link, alt, author, description, caption, name, status, uploadedTo, date, modified, menuOrder, mime, type, subtype, icon, dateFormatted, nonces, editLink, meta, authorName, authorLink, filesizeInBytes, filesizeHumanReadable, context, height, width, orientation, sizes, compat
    */
    <section className="media  media--wide media--gallery component js-has-carousel">
      <div className="media__container">
        <div className="media__header">
          <h2 className="media__title font-h2">{title}</h2>
        </div>
        <div className="media__wrapper">
          <div id="media_items" className="media__items">
            {mediaItems.length > 0
              ? mediaItems.map((item) => {
                  console.log(item);
                  if (item.type === "video") {
                    const youtubeThumbnailUrl = getYouTubeThumbnail(item.url);
                    return (
                      <figure data-itemid={item.id} className="media__imagery media__imagery--with-video">
                        <img
                          src={youtubeThumbnailUrl}
                          alt={item.title}
                          className="media__image"
                          width="836"
                          height="627"
                        />
                        <a href={item.url} className="btn btn--xlarge btn--round play-button">
                          <span className="btn__icon">
                            <svg className="brei-icon brei-icon-play" focusable="false">
                              <use href="#brei-icon-play"></use>
                            </svg>
                          </span>
                          <span className="show-for-sr">Play video</span>
                        </a>
                        <figcaption>{item.caption}</figcaption>
                      </figure>
                    );
                  } else if (item.type === "image") {
                    return (
                      <figure data-itemid={item.id} className="media__imagery">
                        <img src={item.url} alt={item.alt} className="media__image" width="836" height="627" />
                        <figcaption>{item.caption}</figcaption>
                      </figure>
                    );
                  }
                })
              : ""}
          </div>
          <div className="media__controls" data-id="media_controls">
            <div data-id="next">
              <a href="#" aria-label="See Next" className="btn btn--medium">
                <span className="btn__icon">
                  <svg className="brei-icon brei-icon-chevron" focusable="false">
                    <use href="#brei-icon-chevron"></use>
                  </svg>
                </span>
              </a>
            </div>
            <div className="media-amount"></div>
            <div data-id="prev">
              <a href="#" aria-label="See Next" className="btn btn--medium">
                <span className="btn__icon">
                  <svg className="brei-icon brei-icon-chevron" focusable="false">
                    <use href="#brei-icon-chevron"></use>
                  </svg>
                </span>
              </a>
            </div>
          </div>
          <div className="media__caption font-caption" aria-hidden="true"></div>
        </div>

        <div id="media_footer" className="media__footer">
          <div className="media__controls" data-id="media_controls_sm">
            <div data-id="prev">
              <a href="#" aria-label="See Next" className="btn btn--medium">
                <span className="btn__icon">
                  <svg className="brei-icon brei-icon-chevron" focusable="false">
                    <use href="#brei-icon-chevron"></use>
                  </svg>
                </span>
              </a>
            </div>
            <div className="media-amount"></div>
            <div data-id="next">
              <a href="#" aria-label="See Next" className="btn btn--medium">
                <span className="btn__icon">
                  <svg className="brei-icon brei-icon-chevron" focusable="false">
                    <use href="#brei-icon-chevron"></use>
                  </svg>
                </span>
              </a>
            </div>
          </div>
          {description && <p className="media__copy font-body-lite">{description}</p>}
          {includeLink ? (
            <a href={linkUri} className="btn btn-tertiary btn-tertiary-left">
              <span className="text">{linkText ? linkText : "View More"}</span>
              <span className="text-arrow">
                <svg className="brei-icon brei-icon-arrows" focusable="false">
                  <use href="#brei-icon-arrows"></use>
                </svg>

                <svg className="brei-icon brei-icon-arrows-arrow" focusable="false">
                  <use href="#brei-icon-arrows-arrow"></use>
                </svg>
              </span>
            </a>
          ) : (
            ""
          )}
        </div>
      </div>
    </section>
  );
};
export default MediaCarousel;
