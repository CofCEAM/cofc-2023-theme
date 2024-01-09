const PodcastPlatforms = ({ attributes }) => {
  const { title, apple, google, spotify, stitcher, iheart } = attributes;
  return (
    <div class="rail-podcast">
      <div class="rail-podcast__content">
        <h2 class="font-h5">{title ? title : "Subscribe on your preferred platform"}</h2>
      </div>
      <hr></hr>
      <ul className="rail-podcast__list">
        {apple && (
          <li className="rail-podcast__item">
            <a href={apple} class="rail-podcast__link" aria-label="" target="_blank">
              <img
                src={`${cofctheme.template_directory_uri}/assets/images/icon-apple.svg`}
                alt="Apple Podcast"
                width="25"
                height="25"
                aria-hidden="true"
              ></img>
              <div class="rail-podcast__text">
                Listen on
                <br />
                <span>Apple Podcasts</span>
              </div>
            </a>
          </li>
        )}
        {spotify && (
          <li className="rail-podcast__item">
            <a href={spotify} class="rail-podcast__link" aria-label="" target="_blank">
              <img
                src={`${cofctheme.template_directory_uri}/assets/images/icon-spotify.svg`}
                alt="Spotify"
                width="25"
                height="25"
                aria-hidden="true"
              ></img>
              <div class="rail-podcast__text">
                Listen on
                <br />
                <span>Spotify</span>
              </div>
            </a>
          </li>
        )}
        {stitcher && (
          <li className="rail-podcast__item">
            <a href={stitcher} class="rail-podcast__link" aria-label="" target="_blank">
              <img
                src={`${cofctheme.template_directory_uri}/assets/images/icon-stitcher.svg`}
                alt="Stitcher"
                width="25"
                height="25"
                aria-hidden="true"
              ></img>
              <div class="rail-podcast__text">
                Listen on
                <br />
                <span>Stitcher</span>
              </div>
            </a>
          </li>
        )}
        {google && (
          <li className="rail-podcast__item">
            <a href={google} class="rail-podcast__link" aria-label="" target="_blank">
              <img
                src={`${cofctheme.template_directory_uri}/assets/images/icon-google.svg`}
                alt="Google Podcast"
                width="25"
                height="25"
                aria-hidden="true"
              ></img>
              <div class="rail-podcast__text">
                Listen on
                <br />
                <span>Google Podcasts</span>
              </div>
            </a>
          </li>
        )}
        {iheart && (
          <li className="rail-podcast__item">
            <a href={iheart} class="rail-podcast__link" aria-label="" target="_blank">
              <img
                src={`${cofctheme.template_directory_uri}/assets/images/icon-iheart-radio.svg`}
                alt="iHeartRadio"
                width="25"
                height="25"
                aria-hidden="true"
              ></img>
              <div class="rail-podcast__text">
                Listen on
                <br />
                <span>iHeartRadio</span>
              </div>
            </a>
          </li>
        )}
      </ul>
    </div>
  );
};
export default PodcastPlatforms;
