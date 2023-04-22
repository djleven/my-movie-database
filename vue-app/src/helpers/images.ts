import { Sizes } from '@/models/settings'

const images_uri = "https://image.tmdb.org/t/p/"
export const getImageUrl = (
    fileName,
    size: Sizes = Sizes.Large,
    imageType: ImageType = ImageType.Rectangular
) => {
    const images = imageType === ImageType.Rectangular ? rectangularImages : squareImages
    const image = images[size]
    if(!fileName) {
        return require(`../assets/img/mmdb-placeholder-${image.width}.png`)
    }
    return images_uri + image.path + "/" + fileName;
}

export enum ImageType {
    Rectangular = 'rectangular',
    Square = 'square',
}

type ImageSize = {
    width: number,
    height: number
}

type ImageSizes = {
    [Sizes.Small]: ImageSize,
    [Sizes.Medium]: ImageSize,
    [Sizes.Large]: ImageSize,
}

export const rectangularImageSizes: ImageSizes = {
    [Sizes.Small]: {
        width: 154,
        height: 231
    },
    [Sizes.Medium]: {
        width: 185,
        height: 278
    },
    [Sizes.Large]: {
        width: 342,
        height: 513
    },
}

export const squareImageSizes: ImageSizes = {
    [Sizes.Small]: {
        width: 132,
        height: 132
    },
    [Sizes.Medium]: {
        width: 180,
        height: 180
    },
    [Sizes.Large]: {
        width: 300,
        height: 300
    },
}

type Image = ImageSize & {
    path: string
}

type Images = {
    [Sizes.Small]: Image,
    [Sizes.Medium]: Image,
    [Sizes.Large]: Image,
}

const squareImages: Images = {
    [Sizes.Small]: Object.assign(
        squareImageSizes[Sizes.Small], {
            path: 'w132_and_h132_bestv2'
        }
    ),
    [Sizes.Medium]:Object.assign(
        squareImageSizes[Sizes.Medium], {
            path: 'w180_and_h180_bestv2'
        }
    ),
    [Sizes.Large]: Object.assign(
        squareImageSizes[Sizes.Large], {
            path: 'w300_and_h300_bestv2'
        }
    ),
}

const rectangularImages: Images = {
    [Sizes.Small]: Object.assign(
        rectangularImageSizes[Sizes.Small], {
            path: 'w154'
        }
    ),
    [Sizes.Medium]:Object.assign(
        rectangularImageSizes[Sizes.Medium], {
            path: 'w185'
        }
    ),
    [Sizes.Large]: Object.assign(
        rectangularImageSizes[Sizes.Large], {
            path: 'w342'
        }
    ),
}
