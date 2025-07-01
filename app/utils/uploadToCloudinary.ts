export async function uploadImageToCloudinary(imageUri: string): Promise<string> {
    const data = new FormData();

    data.append('file', {
        uri: imageUri,
        type: 'image/jpeg',
        name: 'profile.jpg',
    } as any);

    data.append('upload_preset', 'tu_upload_preset'); // ← reemplaza
    data.append('cloud_name', 'tu_cloud_name'); // ← reemplaza

    const res = await fetch('https://api.cloudinary.com/v1_1/tu_cloud_name/image/upload', {
        method: 'POST',
        body: data,
    });

    const json = await res.json();

    if (!json.secure_url) throw new Error('No se pudo subir la imagen');

    return json.secure_url;
}
