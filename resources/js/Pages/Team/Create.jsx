import React from 'react';
import { Link } from '@inertiajs/react';
import CustomHeader from '@/Layouts/CustomHeader';
import {
    ChakraProvider,
    defaultSystem,
    Text,
    Box,
    Table,
    TableRoot,
    Image,
    HStack,
    StackSeparator,
    // Link,
    Button,
    Center,
    Input,
    NativeSelect,
    NativeSelectRoot,
    NativeSelectField,
    VStack,
    Stack,
    Card
} from '@chakra-ui/react';
import { Field } from '../../../../src/components/ui/field';


const CustomCreate = () => {
    return (
        <ChakraProvider value={defaultSystem}>
        <>
            <CustomHeader />

            {/* メイン */}
                <Box className='main' width="60vh" m="auto" bg='white' marginTop='20px' boxShadow='md'>
                    <Card.Root maxW="md">
                        <Card.Header m="auto">
                            <Card.Title>チーム登録フォーム</Card.Title>
                            <Card.Description>
                                新しくチーム情報を登録します。
                            </Card.Description>
                        </Card.Header>
                        <Card.Body>
                            <Stack gap="4" w="full">
                                <Field label="チーム名">
                                    <Input
                                        placeholder='チーム名を入力してください'
                                        type='text'
                                        id='team_name'
                                        name='team_name'
                                        value={FormData.team_name}
                                    />
                                </Field>
                                <Field label="種目">
                                    <NativeSelectRoot>
                                        <NativeSelectField placeholder='種目マスタを選択してください'>
                                            <option value="1">サッカー</option>
                                            <option value="2">バスケ</option>
                                        </NativeSelectField>
                                    </NativeSelectRoot>
                                </Field>
                            </Stack>
                        </Card.Body>
                        <Card.Footer justifyContent="flex-end">
                            <Button as={Link} href={`/teams`} color='white' bg='gray.500' size='lg' p='5' width='30%'>戻る</Button>
                            <Button type='submit' color='white' bg='orange.500' size='lg' p='5' width='30%'>登録</Button>
                        </Card.Footer>
                    </Card.Root>

                </Box>

        </>
        </ChakraProvider>
    );
}

export default CustomCreate;
